<?php declare(strict_types=1);

namespace App\Tests\Common\DataFixtures\Php;

use App\Entity\Post;
use Doctrine\Persistence\ObjectManager;

// php bin/console doctrine:fixtures:load
final class PostFixture
{
    public function load(ObjectManager $manager)
    {
        $post = new Post();
        $post->setTitle('First Post');
        $post->setBody('This is the body of the post');
        $manager->persist($post);
        $manager->flush();
    }
}
