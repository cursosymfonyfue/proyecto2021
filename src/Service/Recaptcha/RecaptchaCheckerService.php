<?php

declare(strict_types=1);

namespace App\Service\Recaptcha;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Exception\ValidatorException;

/**
 * Class ReCaptchaCheckerService.
 */
class RecaptchaCheckerService
{
    private const RECAPTCHA_PARAM_FIELD = 'recaptcha';
    /**
     * @var RecaptchaProvider
     */
    private RecaptchaProvider $recaptchaProvider;

    /**
     * @var bool
     */
    private bool $enabled;

    /**
     * @param RecaptchaProvider $recaptchaProvider
     * @param bool              $enabled
     */
    public function __construct(
        RecaptchaProvider $recaptchaProvider,
        bool $enabled)
    {
        $this->recaptchaProvider = $recaptchaProvider;
        $this->enabled = $enabled;
    }

    /**
     * @param string $captchaValue
     *
     * @throws BadRequestHttpException
     *
     * @return bool
     */
    public function checkRecaptcha(string $captchaValue): bool
    {
        if (!$this->isEnabled()) {
            return true;
        }

        try {
            $isRecaptchaValid = $this->verify($captchaValue);

            return $isRecaptchaValid;
        } catch (ValidatorException $exception) {
            throw new BadRequestHttpException($exception->getMessage());
        }

        return false;
    }

    /**
     * @return bool
     */
    private function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param string $captchaValue
     *
     * @return bool
     */
    private function verify(string $captchaValue): bool
    {
        return $this->recaptchaProvider->verify($captchaValue);
    }
}
