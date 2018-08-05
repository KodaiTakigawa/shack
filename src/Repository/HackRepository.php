<?php

namespace App\Repository;

use App\Entity\Hack;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Hack|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hack|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hack[]    findAll()
 * @method Hack[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HackRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Hack::class);
    }

//    /**
//     * @return Hack[] Returns an array of Hack objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Hack
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
