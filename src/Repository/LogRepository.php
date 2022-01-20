<?php

namespace App\Repository;

use App\Entity\Log;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Log|null find($id, $lockMode = null, $lockVersion = null)
 * @method Log|null findOneBy(array $criteria, array $orderBy = null)
 * @method Log[]    findAll()
 * @method Log[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Log::class);
    }

    public function add(Log $log)
    {
        $this->getEntityManager()->persist($log);
        $this->handleCommand();
    }

    private function handleCommand(): void
    {
        $this->getEntityManager()->beginTransaction();

        try {
            $this->getEntityManager()->flush();
            $this->getEntityManager()->commit();
            $this->getEntityManager()->clear();
        } catch (\Throwable $e) {
            $this->getEntityManager()->close();
            $this->getEntityManager()->rollback();
            throw $e;
        }
    }
}
