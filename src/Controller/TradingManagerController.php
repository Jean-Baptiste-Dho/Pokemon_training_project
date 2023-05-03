<?php

namespace App\Controller;

use App\Entity\CapturedPokemon;
use App\Entity\Dresseur;
use App\Entity\TradingManager;
use App\Form\TradingFormType;
use App\Trait\DresseurTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class TradingManagerController extends AbstractController
{
    use DresseurTrait;

//    #[Route('/trading/manager', name: 'app_trading_manager')]
//    public function index(): Response
//    {
//        return $this->render('trading_manager/index.html.twig', [
//            'controller_name' => 'TradingManagerController',
//        ]);
//    }

    #[Route('/trading/manager', name: 'app_trading_manager')]
    public function getTrade(EntityManagerInterface $entityManager, Request $request,): Response
    {
        $trade = new TradingManager();

        $user = $this->getUser();

        $form = $this->createForm(TradingFormType::class, $trade);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pokemon = $form->getData();
//          $entityManager->persist($pokemon);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Pokémon mis à jour avec succès !'
            );


            return $this->redirectToRoute('app_main');
        }


        return $this->render('trading_manager/oto.html.twig', [
            'user' => $user,
            'trade' => $trade,
            'tradingForm' => $form->createView()

        ]);
    }

    #[Route('/trading/manager/oneToOne/{id}', name: 'app_trading_oto-2')]
    public function chooseBuyer(int $id, EntityManagerInterface $entityManager): Response
    {
        $dresseurRepo = $entityManager->getRepository(Dresseur::class);


        $dresseur = $dresseurRepo->findAll($this->getDresseur()->getName());
//        dd($dresseur);

        return $this->render('trading_manager/oto.html.twig', [
            'dresseur' => $dresseur,
        ]);
    }

}
