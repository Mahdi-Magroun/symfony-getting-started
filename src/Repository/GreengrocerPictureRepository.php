<?php

namespace App\Repository;

use App\Entity\GreengrocerPicture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GreengrocerPicture>
 *
 * @method GreengrocerPicture|null find($id, $lockMode = null, $lockVersion = null)
 * @method GreengrocerPicture|null findOneBy(array $criteria, array $orderBy = null)
 * @method GreengrocerPicture[]    findAll()
 * @method GreengrocerPicture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GreengrocerPictureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GreengrocerPicture::class);
    }

    public function add(GreengrocerPicture $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(GreengrocerPicture $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return GreengrocerPicture[] Returns an array of GreengrocerPicture objects
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

//    public function findOneBySomeField($value): ?GreengrocerPicture
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
