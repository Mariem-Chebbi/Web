<?php

namespace App\Repository;

use App\Entity\GestionnaireStock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GestionnaireStock>
 *
 * @method GestionnaireStock|null find($id, $lockMode = null, $lockVersion = null)
 * @method GestionnaireStock|null findOneBy(array $criteria, array $orderBy = null)
 * @method GestionnaireStock[]    findAll()
 * @method GestionnaireStock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GestionnaireStockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GestionnaireStock::class);
    }

    public function save(GestionnaireStock $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(GestionnaireStock $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return GestionnaireStock[] Returns an array of GestionnaireStock objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GestionnaireStock
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
