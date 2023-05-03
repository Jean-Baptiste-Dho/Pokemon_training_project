<?php

namespace App\Controller;

use App\Entity\Dresseur;
use App\Trait\DresseurTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class MainController extends AbstractController
{
    use DresseurTrait;

    #[Route('/accueil', name: 'app_main')]
    public function Accueil(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getDresseur()->getName();

        $dresseurRepo = $entityManager->getRepository(Dresseur::class);

        $dresseur = $dresseurRepo->findAll($this->getDresseur()->getName());
        return $this->render('main/accueil.html.twig', [
            'dresseurs' => $dresseur,
            'user' => $user
        ]);
    }

//    #[Route('/test', name: 'app_test')]
//    public function testage(?Profiler $profiler) {
//            dump($profiler->isEnabled());exit;
//
//        return new JsonResponse("blabla");
//    }
}
