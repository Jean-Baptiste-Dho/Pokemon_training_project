<?php

namespace App\Repository;

use App\Entity\Pokemon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pokemon>
 *
 * @method Pokemon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pokemon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pokemon[]    findAll()
 * @method Pokemon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PokemonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pokemon::class);
    }

    public function save(Pokemon $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Pokemon $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Pokemon[] Returns an array of Pokemon objects
     */
    public function findPokePaginated(int $page = 1, int $limit = 25): Paginator
    {
        $limit = abs($limit);

        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('p')
            ->from('App:Pokemon', 'p')
            ->orderBy('p.pokedexId', 'ASC')
            ->setMaxResults($limit)
            ->setFirstResult(($page - 1) * $limit);

        $paginator = new Paginator($query);

        return $paginator;
    }

    public function findAllOrderedQB(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.pokedexId', 'asc');
    }

    public function findLastNumber()
    {
        return $this->createQueryBuilder('p')
            ->select('MAX(p.pokedexId)')
            ->getQuery()
            ->getSingleScalarResult();

    }
}
