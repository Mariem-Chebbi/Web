<?php

namespace App\Repository;

use App\Entity\CreneauHoraire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CreneauHoraire>
 *
 * @method CreneauHoraire|null find($id, $lockMode = null, $lockVersion = null)
 * @method CreneauHoraire|null findOneBy(array $criteria, array $orderBy = null)
 * @method CreneauHoraire[]    findAll()
 * @method CreneauHoraire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreneauHoraireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CreneauHoraire::class);
    }

    public function save(CreneauHoraire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CreneauHoraire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findActiveEtat()
    {
        return $this->createQueryBuilder('u')
            ->where('u.etat = 1')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return CreneauHoraire[] Returns an array of CreneauHoraire objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?CreneauHoraire
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
