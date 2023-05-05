<?php

namespace App\Repository;

use App\Entity\CapturedPokemon;
use App\Entity\Dresseur;
use App\Entity\Pokemon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CapturedPokemon>
 *
 * @method CapturedPokemon|null find($id, $lockMode = null, $lockVersion = null)
 * @method CapturedPokemon|null findOneBy(array $criteria, array $orderBy = null)
 * @method CapturedPokemon[]    findAll()
 * @method CapturedPokemon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CapturedPokemonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CapturedPokemon::class);
    }

    public function save(CapturedPokemon $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CapturedPokemon $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CapturedPokemon[] Returns an array of CapturedPokemon objects
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

//    public function findOneBySomeField($value): ?CapturedPokemon
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }


    public function findMyQB(Dresseur $dresseur): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->where('p.dresseur = :dresseur')
            ->setParameter('dresseur', $dresseur);
    }

    public function findMyByTypeQB(Dresseur $dresseur, Pokemon $pokemon): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->where('p.dresseur = :dresseur')
            ->andWhere('p.pokemon = :pokemon')
            ->setParameter('dresseur', $dresseur)
            ->setParameter('pokemon', $pokemon);
    }

    public function findNotMyQB(Dresseur $dresseur): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->where('p.dresseur != :dresseur')
            ->setParameter('dresseur', $dresseur);
    }

//    public function findByDresseur($id)
//    {
//        $arrayIds = array();
//
//        $qb = $this->createQueryBuilder('cp')
//            ->select('cp.id')
//            ->where('cp.dresseur = :id')
//            ->setParameter('id', $id)
//            ->getQuery()->getResult();
//        return $qb;
//        foreach ($qb as $key => $value) {
//            $arrayIds[$value['id']] = $value['id'];
//        }
//        return $arrayIds;
//    }
}
