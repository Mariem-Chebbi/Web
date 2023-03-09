<?php

namespace App\Repository;

use App\Entity\RendezVous;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RendezVous>
 *
 * @method RendezVous|null find($id, $lockMode = null, $lockVersion = null)
 * @method RendezVous|null findOneBy(array $criteria, array $orderBy = null)
 * @method RendezVous[]    findAll()
 * @method RendezVous[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RendezVousRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RendezVous::class);
    }

    public function save(RendezVous $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RendezVous $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function lastInsertedRDV()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function orderedRdv()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.date_rdv', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function orderedCurrentRdv($id)
    {
        return $this->createQueryBuilder('u')
            ->where('u.date_rdv >= now()')
            ->andWhere('u.client = ' + $id)
            ->orderBy('u.date_rdv', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function orderedHistoryRdv($id)
    {
        return $this->createQueryBuilder('u')
            ->where('u.date_rdv < now()')
            ->andWhere('u.client = ' + $id)
            ->orderBy('u.date_rdv', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function searchByDate(string $date)
    {
        return $this->createQueryBuilder('u')
            ->where('u.date_rdv like :date')
            ->setParameter('date', $date . '%')
            ->getQuery()
            ->getResult();
    }


    //    /**
    //     * @return RendezVous[] Returns an array of RendezVous objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?RendezVous
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
