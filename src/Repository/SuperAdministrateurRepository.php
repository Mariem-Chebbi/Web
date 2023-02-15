<?php

namespace App\Repository;

use App\Entity\SuperAdministrateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SuperAdministrateur>
 *
 * @method SuperAdministrateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method SuperAdministrateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method SuperAdministrateur[]    findAll()
 * @method SuperAdministrateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuperAdministrateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SuperAdministrateur::class);
    }

    public function save(SuperAdministrateur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SuperAdministrateur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return SuperAdministrateur[] Returns an array of SuperAdministrateur objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SuperAdministrateur
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
