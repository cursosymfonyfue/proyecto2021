<?php declare(strict_types=1);

namespace App\Context\Admin\Publication\Form\DataTransformer;

use App\Core\Util\Numbers;
use K2K\K2K\Util\Strings;
use Symfony\Component\Form\DataTransformerInterface;

final class EstadoDataTransformer implements DataTransformerInterface
{
    // ToForm
    public function transform($value)
    {
        $estadosValidos = ['1' => 'Activo', '0' => 'Inactivo'];
        if (!array_key_exists($value, $estadosValidos)) {
            return '';
        }
        return $estadosValidos[(string)$value];
    }

    // FromForm    
    public function reverseTransform($value)
    {
        $estadosValidos = ['Activo' => 1, 'Inactivo' => 0];

        if (!array_key_exists($value, $estadosValidos)) {
            return null;
        }
        return $estadosValidos[(string)$value];
    }
}
