<?php

declare(strict_types=1);

namespace App\Context\Admin\Post\Form\Validator;

use App\Entity\Post;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class BodyContainsAtCharacterConstraintValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /** @var Post $postEntity */
        $postEntity = $this->context->getRoot()->getData();

        if (false !== strpos($postEntity->getBody(), '@')) {
            $this->context->buildViolation($constraint->message)
                          ->addViolation()
            ;
        }
    }
}
