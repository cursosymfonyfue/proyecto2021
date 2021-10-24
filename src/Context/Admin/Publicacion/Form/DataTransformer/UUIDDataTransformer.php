<?php declare(strict_types=1);

namespace App\Context\Admin\Publicacion\Form\DataTransformer;

use App\Core\Util\Numbers;
use K2K\K2K\Util\Strings;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Uid\UuidV4;

final class UUIDDataTransformer implements DataTransformerInterface
{
    // ToForm
    public function transform($value)
    {
        if (null === $value) {
            return '';
        }

        /** @var null|UuidV4 $value */
        return $value->toRfc4122();
    }

    // FromForm
    public function reverseTransform($value)
    {
        if (null === $value) {
            return null;
        }

        return Uuid::fromRfc4122($value);
    }
}
