<?php

declare(strict_types=1);

namespace App\Service\Recaptcha;

use App\Service\Ip\IpResolverInterface;
use ReCaptcha\ReCaptcha;

/**
 * Class GoogleRecaptchaProvider.
 */
class GoogleRecaptchaProvider extends RecaptchaProvider
{
    private const SCORE_THRESHOLD = 0.7;
    /**
     * @var ReCaptcha
     */
    private ReCaptcha $recaptcha;

    /**
     * @var IpResolverInterface
     */
    private IpResolverInterface $ipResolver;

    /**
     * GoogleRecaptchaProvider constructor.
     *
     * @param ReCaptcha           $recaptcha
     * @param IpResolverInterface $ipResolver
     */
    public function __construct(ReCaptcha $recaptcha, IpResolverInterface $ipResolver)
    {
        $this->recaptcha = $recaptcha;
        $this->ipResolver = $ipResolver;
    }

    /**
     * @param string $captchaValue
     *
     * @return bool
     */
    public function verify(string $captchaValue): bool
    {
        $ip = $this->ipResolver->resolveIp();

        $this->recaptcha->setScoreThreshold(self::SCORE_THRESHOLD);

        $response = $this->recaptcha->verify($captchaValue, $ip);

        return $response->isSuccess();

    }

}
