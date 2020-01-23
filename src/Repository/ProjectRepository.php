<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    // /**
    //  * @return article[] Returns an array of article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return Project[] Returns an array of Article objects
     */
    public function findFavorite()
    {
       return $this->createQueryBuilder('project')
            ->andWhere('project.favorite = true')
            ->andWhere('project.published = true')
            ->orderBy('project.updatedAt', 'ASC')
            //->setMaxResults(3)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return Project[] Returns an array of Article objects
     */
    public function findAllExecptFavorite()
    {
        return $this->createQueryBuilder('project')
            ->andWhere('project.favorite = false')
            ->andWhere('project.published = true')
            ->orderBy('project.updatedAt', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
}
