<?php

namespace App\Controller;

use App\Entity\CapturedPokemon;
use App\Entity\Dresseur;
use App\Entity\Trade;
use App\Form\CreateTradingFormType;
use App\Form\FinaliseTradingFormType;
use App\Repository\TradeRepository;
use App\Security\Voter\TradeVoter;
use App\Trait\DresseurTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use function Webmozart\Assert\Tests\StaticAnalysis\throws;

class TradingManagerController extends AbstractController
{
    use DresseurTrait;

    #[Route('/trading/manager', name: 'app_trading_manager')]
    public function getTrade(EntityManagerInterface $entityManager, Request $request): Response
    {
        $trade = new Trade();

        $user = $this->getUser();

        $form = $this->createForm(CreateTradingFormType::class, $trade);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($trade);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Échange en cours -  Consultez vos messages pour suivre la transaction!'
            );


            return $this->redirectToRoute('app_main_accueil');
        }


        return $this->render('trading_manager/create.html.twig', [
            'user' => $user,
            'trade' => $trade,
            'tradingForm' => $form->createView()

        ]);
    }

    #[Route('/trade/delete/{id}', name: 'trade_delete')]
    public function delete(int $id, EntityManagerInterface $entityManager): Response
    {
        $trade = $entityManager->getRepository(Trade::class)->find($id);
        $this->denyAccessUnlessGranted(TradeVoter::DELETE, $trade);

        if (!$trade) {
            throw $this->createNotFoundException('Échange non trouvé');
        }

        $entityManager->remove($trade);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Vous avez annulé votre offre num°' . $trade->getId()
        );

        return $this->redirectToRoute('app_main_accueil');
    }


    #[Route('/trading/manager/finalise/{id}', name: 'app_trading_finalise')]
    public function finalise(int $id, EntityManagerInterface $entityManager, Request $request): Response
    {
        $trade = $entityManager->getRepository(Trade::class)->find($id);

        if (!$trade) {
            throw $this->createNotFoundException('Trade doesnt exist');
        }

        //TODO status = pending

        //TODO check que j'ai le droit

        // ou faire un voter qui fait tout ça

        $user = $this->getUser();

        $form = $this->createForm(FinaliseTradingFormType::class, $trade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($trade->isAccepted()) {
                $buyer = $trade->getBuyer();
                $seller = $trade->getSeller();
                $trade->getCapturedPokemonBuyer()->setDresseur($seller);
                $trade->getCapturedPokemonSeller()->setDresseur($buyer);
                $message = 'Échange finalisé, vous avez échangé votre pokémon !';

            } else {
                $message = 'Échange invalidé, vous avez rien fait !';
            }

            $entityManager->flush();
            $this->addFlash(
                'success',
                $message
            );

//            return $this->redirectToRoute('app_dresseur');
        }

        return $this->render('trading_manager/finalise.html.twig', [
            'user' => $user,
            'trade' => $trade,
            'finalForm' => $form->createView()

        ]);
    }


}
