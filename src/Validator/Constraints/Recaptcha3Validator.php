<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Service\Recaptcha\RecaptchaCheckerService;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class Recaptcha3Validator extends ConstraintValidator
{
    /**
     * @var RecaptchaCheckerService
     */
    private RecaptchaCheckerService $recaptchaService;

    public function __construct(RecaptchaCheckerService $recaptchaService)
    {
        $this->recaptchaService = $recaptchaService;
    }

    /**
     * @param mixed      $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        if (null !== $value && !is_scalar($value) && !(\is_object($value) && method_exists($value, '__toString'))) {
            throw new UnexpectedTypeException($value, 'string');
        }
        if (!$constraint instanceof Recaptcha3) {
            throw new UnexpectedTypeException($constraint, Recaptcha3::class);
        }

        $value = null !== $value ? (string) $value : '';

        $this->validateCaptcha($value, $constraint);
    }

    private function validateCaptcha(string $value, Recaptcha3 $constraint): void
    {
        if ('' === $value) {
            $this->buildViolation($constraint->messageMissingValue, $value);

            return;
        }

        $isValid = $this->recaptchaService->checkRecaptcha($value);

        if (!$isValid) {
            $this->buildViolation($constraint->messageMissingValue, $value);
        }
    }

    private function buildViolation(string $message, string $value, string $errorCodes = ''): void
    {
        $this->context->buildViolation($message)
            ->setParameter('{{ value }}', $this->formatValue($value))
            ->setParameter('{{ errorCodes }}', $this->formatValue($errorCodes))
            ->setCode(Recaptcha3::INVALID_FORMAT_ERROR)
            ->addViolation();
    }
}
