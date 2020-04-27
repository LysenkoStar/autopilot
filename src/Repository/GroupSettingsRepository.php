<?php

namespace App\Repository;

use App\Entity\GroupSettings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method GroupSettings|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroupSettings|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroupSettings[]    findAll()
 * @method GroupSettings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupSettingsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupSettings::class);
    }

    // /**
    //  * @return GroupSettings[] Returns an array of GroupSettings objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GroupSettings
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
