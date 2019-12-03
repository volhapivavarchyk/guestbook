<?php
declare(strict_types=1);

namespace Piv\Guestbook\Repository;

use Piv\Guestbook\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function findByOrderByDate($criteria, $orderBy)
    {
        return $this->createQueryBuilder('m')
            ->select('m', 'u')
            ->where('m.'.key($criteria).' = :criteria')
            ->setParameter('criteria', $criteria[key($criteria)])
            ->leftJoin('m.user','u')
            ->orderBy('m.date', $orderBy)
            ->getQuery()
            ->getResult();
    }

    public function findByOrderByUsername($criteria, $orderBy)
    {
        return $this->createQueryBuilder('m')
            ->select('m', 'u')
            ->where('m.'.key($criteria).' = :criteria')
            ->setParameter('criteria', $criteria[key($criteria)])
            ->leftJoin('m.user','u')
            ->orderBy('u.username', $orderBy)
            ->getQuery()
            ->getResult();
    }

    public function findByOrderByEmail($criteria, $orderBy)
    {
        return $this->createQueryBuilder('m')
            ->select('m', 'u')
            ->where('m.'.key($criteria).' = :criteria')
            ->setParameter('criteria', $criteria[key($criteria)])
            ->leftJoin('m.user','u')
            ->orderBy('u.email', $orderBy)
            ->getQuery()
            ->getResult();
    }
}
