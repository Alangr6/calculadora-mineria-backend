<?php

namespace App\Repository;

use App\Entity\Crypto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Crypto|null find($id, $lockMode = null, $lockVersion = null)
 * @method Crypto|null findOneBy(array $criteria, array $orderBy = null)
 * @method Crypto[]    findAll()
 * @method Crypto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CryptoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Crypto::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Crypto $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        /* if ($flush) {
            $this->_em->flush();
        } */
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Crypto $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    
    public function getAll()
    {
        return $this->createQueryBuilder('c')
            ->getQuery()
            ->getArrayResult()
            
        ;
    }

    public function findByName($name){
        $qb =  $this->createQueryBuilder('crypto')
            ->where('crypto.name = :name')
            ->setParameter('name',$name)
            ->orderBy('crypto.name')
        ;
        return $qb->getQuery()->execute();
    }
   

    /*
    public function findOneBySomeField($value): ?Crypto
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
