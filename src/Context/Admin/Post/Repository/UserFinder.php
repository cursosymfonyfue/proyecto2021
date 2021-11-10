<?php declare(strict_types=1);

namespace App\Context\Admin\Post\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;

final class UserFinder
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function findFirstUser(): ?User
    {
        $query = $this->em
            ->getRepository(User::class)
            ->createQueryBuilder('user')
            ->setMaxResults(1)
            ->orderBy('user.id', 'DESC')
            ->getQuery();

        return $query->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true)->getOneOrNullResult();
    }
}
