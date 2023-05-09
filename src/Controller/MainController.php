<?php

namespace App\Controller;

use App\Entity\CapturedPokemon;
use App\Entity\Dresseur;
use App\Entity\Trade;
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
    public function Accueil(TradeRepository $tradeRepo): Response
    {
        $dresseur = $this->getDresseur();
        $currentTrades = $tradeRepo->getCurrentTrades($dresseur);
        $everyoneTrades = $tradeRepo->getCurrentOpportunities($dresseur);
        return $this->render('main/accueil.html.twig', [
            'dresseur' => $dresseur,
            'trades' => $currentTrades,
            'everyoneTrades' => $everyoneTrades,
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
