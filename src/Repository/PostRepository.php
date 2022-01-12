<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function findPostBySearchCriteria(string $searchTerm)
    {
        $query = $this->createQueryBuilder('p')
                      ->join('p.user', 'u')
                      ->orWhere('u.username LIKE :searchTerm')
                      ->orWhere('p.title LIKE :searchTerm')
                      ->orWhere('p.body LIKE :searchTerm')
                      ->setParameter('searchTerm', "%$searchTerm%")
                      ->getQuery();

        return $query->getResult();
    }

    public function incrementNumberOfLikesByOne(int $id): void
    {
        if (empty($id)) {
            return;
        }

        $this->getEntityManager()->getConnection()->executeQuery('UPDATE post SET likes=likes+1 where id = :id', ['id' => $id]);
    }
}
