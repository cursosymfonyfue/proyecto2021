<?php

declare(strict_types=1);

namespace App\Context\Admin\Post\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

final class NullToBlankTransformer implements DataTransformerInterface
{
    // From Database/FileSystem To Form
    public function transform($value)
    {
        return $value;
    }

    // From Form to Database/FileSystem
    public function reverseTransform($value)
    {
        return (string)$value;
    }
}
