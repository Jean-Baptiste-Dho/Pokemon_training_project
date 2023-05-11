<?php

namespace App\Controller;

use App\Pagination\PaginatorFactory;
use App\Repository\PokemonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PokemonController extends AbstractController
{
    #[Route('/pokemon/{page}', name: 'app_pokemonDb', requirements: ['page' => '\d+'])]
    public function allPoke(PokemonRepository $pokemonRepo, PaginatorFactory $factory, ?int $page = 1): Response
    {
        $paginator = $pokemonRepo->findPokePaginated($page, 25);
        $route = 'app_pokemonDb';
        $paginator = $factory->create($paginator, $route);

        return $this->render('main/pokemonDb.html.twig', [
            'paginator' => $paginator
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
