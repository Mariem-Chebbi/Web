<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Product[] Returns an array of Product objects
//     */
//    public function findByLibelle($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

/**
     * Recherche les formations dont le libellé ou la description contient le terme de recherche.
     *
     * @param string $term Le terme de recherche.
     * @return Formation[] Les formations qui correspondent au terme de recherche.
     */
    public function searchByLibelleAndDescription(string $term): array
    {
        return $this->createQueryBuilder('f')
            ->where('f.libelle LIKE :term OR f.description LIKE :term')
            ->setParameter('term', '%' . $term . '%')
            ->orderBy('f.libelle', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findProductByLibelle($recherche)
    {
        return $this->createQueryBuilder('p')
            ->where('p.libelle LIKE :val')
            ->setParameter("val", $recherche . '%')
            ->getQuery()
            ->getResult();
    }

    public function orderByLibelle()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.libelle', 'ASC')
            ->getQuery()
            ->getResult();
    }

    
}
