<?php

namespace App\Controller;

use App\Repository\PokemonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PokemonController extends AbstractController
{
    #[Route('/pokemon', name: 'app_pokemonDb')]
    public function allPoke(PokemonRepository $pokemonRepo): Response
    {
        $pokemon = $pokemonRepo->findByTwentyFive();
//        dd($pokemon);
        return $this->render('main/pokemonDb.html.twig', [
            'pokemons' => $pokemon,
        ]);
    }

//
//    #[Route('/pokemon', name: 'app_pokemonDb')]
//    public function allPoke(PokemonRepository $pokemonRepo): Response
//    {
//        $pokemon = $pokemonRepo->findAll();
////        dd($pokemon);
//        return $this->render('main/pokemonDb.html.twig', [
//            'pokemons' => $pokemon,
//        ]);
//    }
}
