<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

// php bin/console doctrine:fixtures:load
class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('prueba@prueba.prueba');
        $user->setUsername('prueba');
        $user->setPassword($this->encoder->hashPassword($user, 'prueba'));
        $manager->persist($user);
        $manager->flush();

        $post = new Post();
        $post->setTitle('First Post');
        $post->setBody('This is the body of the post');
        $post->setState(1);
        $post->setUser($user);
        $manager->persist($post);
        $manager->flush();
    }
}
