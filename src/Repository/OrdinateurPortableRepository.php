<?php

namespace App\Repository;

use App\Entity\OrdinateurPortable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrdinateurPortable>
 *
 * @method OrdinateurPortable|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrdinateurPortable|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrdinateurPortable[]    findAll()
 * @method OrdinateurPortable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdinateurPortableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrdinateurPortable::class);
    }

//    /**
//     * @return OrdinateurPortable[] Returns an array of OrdinateurPortable objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    /* public function recupererResultatRechercheVisiteur($critereVisiteur)
    {
        $qb = $this->createQueryBuilder("u"); // u est un nom générique
        $query = $qb->select('u')
            ->where('u.prix >= :min')
            ->andWhere('u.prix <= :max')
            ->setParameter('min', $min)
            ->setParameter('max', $max)
            ->getQuery();
        $res = $query->getResult();
    //var_dump ($res);

    return $res;
    } */

    public function recupererResultatRechercheVisiteur($search) 
{
    $query = $this->createQueryBuilder("u");

    if($search->getMarque())
    {
        $query = $query
        ->andWhere('u.marque IN (:marque)')
        ->setParameter(':marque' , $search->getMarque());

    }

    if($search->getPrix_min())
    {
        $query = $query
        ->andWhere('u.prix >= :prix_min')
        ->setParameter(':prix_min' , $search->getPrix_min());

    }

    if($search->getPrix_max())
    {
        $query = $query
        ->andWhere('u.prix <= :prix_max')
        ->setParameter(':prix_max' , $search->getPrix_max());


    }

    if($search->getProcesseur())
    {
        $query = $query
        ->andWhere('u.processeur IN (:processeur)')
        ->setParameter(':proccesseur' , $search->getProcesseur());

    }

    if($search->getSystemeExploitation())
    {
        $query = $query
        ->andWhere('u.systemeExploitation IN (:systemeExploitation)')
        ->setParameter(':SystemeExploitation' , $search->getSystemeExploitation());

    }

    return $query
            ->getQuery()
            ->getResult()
    ;
}


}




