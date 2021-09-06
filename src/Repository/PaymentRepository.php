<?php

namespace App\Repository;

use App\Entity\Payment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Payment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Payment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Payment[]    findAll()
 * @method Payment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Payment::class);
    }

    // /**
    //  * @return Payment[] Returns an array of Payment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Payment
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findPaymentBySomeField(array $fields)
    {
        $qb = $this->createQueryBuilder("p");
        if (isset($fields["company"])) {
            $qb->where("p.company = :val")
                ->setParameter("val", $fields["company"]);
        }
        if (isset($fields["payment_date_from"])) {
            $qb->where("p.payment_date >= :val")
                ->setParameter("val", $fields["payment_date_from"]);
        }
        if (isset($fields["payment_date_until"])) {
            $qb->where("p.payment_date <= :val")
                ->setParameter("val", $fields["payment_date_until"]);
        }
        return $qb->orderBy("p.id", "asc")
        ->getQuery()->getResult();
    }
}
