<?php

namespace App\Repository;

use App\Entity\PokemonSpecie;
use App\Entity\Dresseur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PokemonSpecie>
 *
 * @method PokemonSpecie|null find($id, $lockMode = null, $lockVersion = null)
 * @method PokemonSpecie|null findOneBy(array $criteria, array $orderBy = null)
 * @method PokemonSpecie[]    findAll()
 * @method PokemonSpecie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PokemonSpecieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PokemonSpecie::class);
    }

    public function save(PokemonSpecie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PokemonSpecie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
//    find by poke type
    /**
     * @return Dresseur[] Returns an array of Dresseur objects
     */
    public function findByType($value): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.type = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }




//    /**
//     * @return PokemonSpecie[] Returns an array of PokemonSpecie objects
//     */
//    public function findByExampleField($value): array
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

//    public function findOneBySomeField($value): ?PokemonSpecie
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
