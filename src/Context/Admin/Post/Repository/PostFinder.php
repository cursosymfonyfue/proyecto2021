<?php declare(strict_types=1);

namespace App\Context\Admin\Post\Repository;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;

final class PostFinder
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function findAll(): array
    {
        $query = $this->em
            ->getRepository(Post::class)
            ->createQueryBuilder('post')
            ->innerJoin('post.user','user')
            ->leftJoin('post.category','category')
            ->addSelect('user')
            ->addSelect('category')
            ->getQuery();
        return $query->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true)->getResult();
    }

    public function findById($id)
    {
        return $this->em->getRepository(Post::class)->find($id);
    }
}
