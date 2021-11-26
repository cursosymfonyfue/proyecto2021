<?php

declare(strict_types=1);

namespace App\Service\Recaptcha;

abstract class RecaptchaProvider
{
    /**
     * Checks captcha captchaValue.
     *
     * @param string $captchaValue
     *
     * @return bool
     */
    abstract public function verify(string $captchaValue): bool;
}
