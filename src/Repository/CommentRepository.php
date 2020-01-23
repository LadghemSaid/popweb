<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    // /**
    //  * @return Comment[] Returns an array of Comment objects
    //  */

    public function findByArticleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.article = :val')
            ->setParameter('val', $value)
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function findProjectComment($id, $order)
    {
        return $this->createQueryBuilder('comment')
            ->andWhere('comment.project = :val')
            ->andWhere('comment.approved = 1')
            ->setParameter('val', $id)
            ->orderBy('comment.created_at' ,$order)
            ->getQuery()
            ->getResult();
    }

    public function findJobComment($id, $order)
    {
        return $this->createQueryBuilder('comment')
            ->andWhere('comment.job = :val')
            ->andWhere('comment.approved = 1')
            ->setParameter('val', $id)
            ->orderBy('comment.created_at' ,$order)
            ->getQuery()
            ->getResult();
    }

    public function findArticleComment($id, $order)
    {
        return $this->createQueryBuilder('article')
            ->andWhere('article.article = :val')
            ->andWhere('article.approved = 1')
            ->setParameter('val', $id)
            ->orderBy('article.created_at' ,$order)
            ->getQuery()
            ->getResult();
    }


    /*
    public function findOneBySomeField($value): ?Comment
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
