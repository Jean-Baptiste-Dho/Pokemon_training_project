<?php

namespace App\Controller;

use App\Entity\CapturedPokemon;
use App\Entity\Dresseur;
use App\Repository\DresseurRepository;
use App\Repository\TradeRepository;
use App\Trait\DresseurTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class MainController extends AbstractController
{
    use DresseurTrait;

    #[Route('/accueil', name: 'app_main_accueil')]
    public function accueil(TradeRepository $tradeRepo, EntityManagerInterface $em): Response
    {
        $dresseur = $this->getDresseur();
        $podium = $em->getRepository(Dresseur::class)->podium();
        $currentTrades = $tradeRepo->getCurrentTrades($dresseur);
        $everyoneTrades = $tradeRepo->getCurrentOpportunities($dresseur);

        return $this->render('main/accueil.html.twig', [
            'dresseur' => $dresseur,
            'trades' => $currentTrades,
            'everyoneTrades' => $everyoneTrades,
            'podium' => $podium
        ]);
    }

    #[Route('/historique', name: 'historique')]
    public function historique(EntityManagerInterface $entityManager, TradeRepository $tradeRepo): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        $historique = $tradeRepo->getMyTrades($this->getDresseur());

        return $this->render('main/historique.html.twig', [
            'historique' => $historique
        ]);
    }
}
