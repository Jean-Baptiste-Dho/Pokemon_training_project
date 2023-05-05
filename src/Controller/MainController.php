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
    public function Accueil(EntityManagerInterface $entityManager, TradeRepository $tradingManagerRepository): Response
    {
        $user = $this->getDresseur()->getName();
        $id = $this->getDresseur()->getId();

        $dresseurRepo = $entityManager->getRepository(Dresseur::class);
        $capturedPokemonRepo = $entityManager->getRepository(CapturedPokemon::class);
        $tradeRepo = $entityManager->getRepository(Trade::class);

        $dresseur = $dresseurRepo->find($id);
        $capturedPokemons = $capturedPokemonRepo->findByDresseur($id);
        $currentTrades = $tradeRepo->getCurrentTrades($capturedPokemons);


//        $dresseur = $dresseurRepo->findAll($this->getDresseur()->getName());
        return $this->render('main/accueil.html.twig', [
            'dresseurs' => $dresseur,
            'user' => $user,
            'id' => $id,
            'trades' => $currentTrades
        ]);
    }

//    #[Route('/test', name: 'app_test')]
//    public function testage(?Profiler $profiler) {
//            dump($profiler->isEnabled());exit;
//
//        return new JsonResponse("blabla");
//    }
}
