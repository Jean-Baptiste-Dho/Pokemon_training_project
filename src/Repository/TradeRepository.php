<?php

namespace App\Repository;

use App\Entity\CapturedPokemon;
use App\Entity\Dresseur;
use App\Entity\Pokemon;
use App\Entity\Trade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trade>
 *
 * @method Trade|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trade|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trade[]    findAll()
 * @method Trade[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TradeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trade::class);
    }

    public function save(Trade $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Trade $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /*
     * Trade en cours qui vise un de mes CapturedPokemon
     */
    public function getCurrentTrades(Dresseur $dresseur)
    {
        $qb = $this->createPendingQB()
            ->andWhere('t.capturedPokemonBuyer IN (:capturedPokemon)')
            ->setParameter('capturedPokemon', $dresseur->getPokemons());

        return $qb->getQuery()->getResult();
    }

    /*
     * Trade en cours qui cible un type de pokemon que j'ai
     */
    public function getCurrentOpportunities(Dresseur $dresseur)
    {
        $qb = $this->createPendingQB()
            ->leftJoin(CapturedPokemon::class, 'c', 'WITH', 't.pokemon = c.pokemon')
            ->andWhere('c.dresseur = :dresseur')
            ->andWhere('t.capturedPokemonBuyer IS NULL')
            ->setParameter('dresseur', $dresseur);

        return $qb->getQuery()->getResult();
    }

    /*
     * Historique de mes trades
     */
    public function getMyTrades(Dresseur $dresseur)
    {
        $qb = $this->createQueryBuilder('t')
            ->leftJoin('t.capturedPokemonSeller', 'cps')
            ->leftJoin('t.capturedPokemonBuyer', 'cpb')
            ->where('cps.dresseur = :dresseur OR cpb.dresseur = :dresseur')
            ->setParameter('dresseur', $dresseur);
//        dd($qb->getQuery()->getSQL());
        return $qb->getQuery()->getResult();
    }

    private function createPendingQB()
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.pokemon', 'p')
            ->addSelect('p')
            ->where('t.status = :status')
            ->setParameter('status', Trade::PENDING);

    }

//    /**
//     * @return TradingManager[] Returns an array of TradingManager objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TradingManager
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
