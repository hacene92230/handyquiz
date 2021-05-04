<?php

namespace App\Repository;

use App\Entity\Quizreply;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Quizreply|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quizreply|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quizreply[]    findAll()
 * @method Quizreply[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuizreplyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quizreply::class);
    }

    // /**
    //  * @return Quizreply[] Returns an array of Quizreply objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Quizreply
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
