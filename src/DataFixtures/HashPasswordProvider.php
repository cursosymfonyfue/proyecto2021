<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Provider\Base as FakerProviderBase;

final class HashPasswordProvider extends FakerProviderBase
{
    private UserPasswordHasherInterface $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function hashPassword(string $plainPassword): string
    {
        return $this->encoder->hashPassword(new User(), $plainPassword);
    }
}
