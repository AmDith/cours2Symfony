<?php

namespace App\Repository;

use App\Entity\Dette;
use App\Entity\Client;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Dette>
 */
class DetteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dette::class);
    }

//    /**
//     * @return Dette[] Returns an array of Dette objects
//     */
public function paginateDettesByClient(Client $client, int $page, int $limit):Paginator
{
    $query = $this->createQueryBuilder('d')
        ->where('d.client = :client')
        ->setParameter('client', $client)
        ->setFirstResult(($page - 1) * $limit)
        ->setMaxResults($limit)
        ->orderBy('d.id', 'ASC')
        ->getQuery();

        return new Paginator($query);
}

public function countDettesByClient(Client $client): int
{
    $query = $this->createQueryBuilder('d')
        ->select('COUNT(d.id)')
        ->where('d.client = :client')
        ->setParameter('client', $client)
        ->getQuery();

    return (int) $query->getSingleScalarResult();
}


//    public function findOneBySomeField($value): ?Dette
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
