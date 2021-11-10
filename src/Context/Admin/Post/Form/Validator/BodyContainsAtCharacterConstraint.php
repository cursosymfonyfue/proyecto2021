<?php declare(strict_types=1);

namespace App\Context\Admin\Post\Form\Validator;

use Symfony\Component\Validator\Constraint;

/** @Annotation */
final class BodyContainsAtCharacterConstraint extends Constraint
{
    public $message = 'The description must not contain the "@" character';

    public function getTargets()
    {
        return [self::CLASS_CONSTRAINT, self::PROPERTY_CONSTRAINT];
    }

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}
