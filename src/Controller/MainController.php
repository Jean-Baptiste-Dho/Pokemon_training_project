<?php

namespace App\Controller;

use App\Entity\PokemonSpecie;
use App\Entity\Dresseur;
use App\Service\CallPokeApi;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class MainController extends AbstractController
{

    #[Route('/index', name: 'app_main')]
    public function index(EntityManagerInterface  $entityManager): Response
    {
        $pokemonRepo = $entityManager->getRepository(PokemonSpecie::class);
        $dresseurRepo = $entityManager->getRepository(Dresseur::class);


        $dresseur = $dresseurRepo->findAll();
        $pokemons = $pokemonRepo->findAll();
                return $this->render('main/index.html.twig', [
           'pokemonSpecies' => $pokemons,
           'dresseurs' => $dresseur,
        ]);
    }


//    #[Route('/test', name: 'app_test')]
//    public function testage(?Profiler $profiler) {
//            dump($profiler->isEnabled());exit;
//
//        return new JsonResponse("blabla");
//    }
}
