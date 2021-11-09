<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

final class Recaptcha3 extends Constraint
{
    public const INVALID_FORMAT_ERROR = 'a9dde1b9-2b4b-4dd2-9879-ca715b5255eb';

    /** @var string[] */
    protected static $errorNames = [
        self::INVALID_FORMAT_ERROR => 'INVALID_FORMAT_ERROR',
    ];

    public string $message = 'Your computer or network may be sending automated queries';
    public string $messageMissingValue = 'The captcha value is missing or invalid';
}
