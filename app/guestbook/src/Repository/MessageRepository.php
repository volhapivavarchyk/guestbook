<?php
namespace App\Repository;

use Piv\Guestbook\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function findByOrderByUsername()
    {
        return $this->createQueryBuilder('message')
            ->leftJoin('message.user_id','user')
            ->orderBy('user.username', 'asc')
            ->getQuery()
            ->getResult();
    }
}
