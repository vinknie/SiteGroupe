<?php

namespace App\Repository;

use App\Entity\PlanningSubject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PlanningSubject|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlanningSubject|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlanningSubject[]    findAll()
 * @method PlanningSubject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanningSubjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlanningSubject::class);
    }

    // /**
    //  * @return PlanningSubject[] Returns an array of PlanningSubject objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PlanningSubject
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
