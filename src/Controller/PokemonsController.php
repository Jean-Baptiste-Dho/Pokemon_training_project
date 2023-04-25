<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PokemonsController extends AbstractController
{
    #[Route('/pokemons', name: 'app_pokemons')]
    public function index(): Response
    {
        return $this->render('pokemons/index.html.twig', [
            'controller_name' => 'PokemonsController',
        ]);
    }
}
