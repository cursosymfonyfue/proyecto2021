<?php declare(strict_types=1);

namespace App\Context\Admin\Post\Repository;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;

final class PostPersister
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function persist(Post $postEntity): void
    {
        $this->em->persist($postEntity);
        $this->em->flush();
    }

    public function delete(int $id): void
    {
        $postEntity = $this->em->getReference(Post::class, $id);
        $this->em->remove($postEntity);
        $this->em->flush();
    }
}
