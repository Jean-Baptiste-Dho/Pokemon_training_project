<?php

namespace App\Repository;

use App\Entity\Dresseur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<Dresseur>
 *
 * @method Dresseur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dresseur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dresseur[]    findAll()
 * @method Dresseur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DresseurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dresseur::class);
    }

    public function save(Dresseur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Dresseur $entity, bool $flush = false): void
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
        return $this->createQueryBuilder('d')
            ->join('d.pokemonSpecies', 'p')
            ->andWhere('p.type = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findTestage($name)
    {
        return $this->createQueryBuilder('d')
            ->leftJoin('d.pokemons', 'c')
            ->leftJoin('c.pokemon', 'p')
            ->addSelect('c')
            ->addSelect('p')
            ->where('d.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function podium()
    {
        $qb = $this->createQueryBuilder('d')
            ->leftJoin('d.pokemons', 'c')
            ->addSelect('COUNT(c.id) AS counter')
            ->groupBy('d.id')
            ->orderBy('counter', 'desc')
            ->setMaxResults(3)
            ->getQuery()->getResult()//            ->getOneOrNullResult()
        ;
//        dd($qb);
        return $qb;
    }

}
