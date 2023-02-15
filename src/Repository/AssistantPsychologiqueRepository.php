<?php

namespace App\Repository;

use App\Entity\AssistantPsychologique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AssistantPsychologique>
 *
 * @method AssistantPsychologique|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssistantPsychologique|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssistantPsychologique[]    findAll()
 * @method AssistantPsychologique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssistantPsychologiqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AssistantPsychologique::class);
    }

    public function save(AssistantPsychologique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AssistantPsychologique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AssistantPsychologique[] Returns an array of AssistantPsychologique objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AssistantPsychologique
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
