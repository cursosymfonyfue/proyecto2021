<?php declare(strict_types=1);

namespace App\Context\Admin\Publicacion\Form\DataTransformer;

use App\Context\Admin\Publicacion\DTO\PostDTO;
use Symfony\Component\Form\DataTransformerInterface;

final class StateDataTransformer implements DataTransformerInterface
{

    // ToForm
    public function transform($value)
    {
        return $value ? PostDTO::STATES[(string)$value] : null;
    }

    // FromForm
    public function reverseTransform($value)
    {
        return $value;
    }
}
