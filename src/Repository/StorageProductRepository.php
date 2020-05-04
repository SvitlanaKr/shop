<?php

namespace App\Repository;

use App\Entity\StorageProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StorageProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method StorageProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method StorageProduct[]    findAll()
 * @method StorageProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StorageProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StorageProduct::class);
    }

    // /**
    //  * @return StorageProduct[] Returns an array of StorageProduct objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StorageProduct
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
