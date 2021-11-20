<?php declare(strict_types=1);

namespace App\Context\Admin\Post\Form\DataTransformer;

use App\Entity\Post;
use Symfony\Component\Form\DataTransformerInterface;

final class StateDataTransformer implements DataTransformerInterface
{
    // From Database/FileSystem To Form
    public function transform($value)
    {
        // Transforma número a string (o null). Ej: 1 a "active"
        $states = array_flip(Post::STATES);
        return null !== $value ? $states[(string)$value] : null;
    }

    // From Form to Database/FileSystem
    public function reverseTransform($value)
    {
        // Transforma string a número (o null). Ej: "active" a 1
        return null !== $value ? (int)Post::STATES[$value] : null;
    }
}
