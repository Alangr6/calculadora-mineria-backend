<?php

namespace App\Repository;

use App\Entity\CryptoDevice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CryptoDevice|null find($id, $lockMode = null, $lockVersion = null)
 * @method CryptoDevice|null findOneBy(array $criteria, array $orderBy = null)
 * @method CryptoDevice[]    findAll()
 * @method CryptoDevice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CryptoDeviceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CryptoDevice::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(CryptoDevice $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(CryptoDevice $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
     public function getAll(){
        return $this->createQueryBuilder('cd')
        ->select('cd,d,c')
            ->innerJoin('cd.device', 'd' )
            ->innerJoin('cd.crypto', 'c' )
            ->getQuery()
            ->getArrayResult()
        ;
    }

   
    public function getAllByCrypto(){
        return $this->createQueryBuilder('cd')
        ->select('cd,d,c')
            ->innerJoin('cd.device', 'd' )
            ->innerJoin('cd.crypto', 'c' )
            ->andWhere('c.id = :cryptoid')
            ->setParameter('cryptoid' , 1)
            ->getQuery()
            ->getArrayResult()
        ;
    }


    // /**
    //  * @return CryptoDevice[] Returns an array of CryptoDevice objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CryptoDevice
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
