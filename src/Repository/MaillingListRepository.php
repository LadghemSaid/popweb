<?php

namespace App\Repository;

use App\Entity\MaillingList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MaillingList|null find($id, $lockMode = null, $lockVersion = null)
 * @method MaillingList|null findOneBy(array $criteria, array $orderBy = null)
 * @method MaillingList[]    findAll()
 * @method MaillingList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaillingListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MaillingList::class);
    }

    // /**
    //  * @return MaillingList[] Returns an array of MaillingList objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MaillingList
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
