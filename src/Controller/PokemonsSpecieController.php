<?php

namespace App\Controller;

use App\Entity\Dresseur;
use App\Entity\PokemonSpecie;
use App\Form\PokemonsAddFormType;
use App\Service\CallPokeApi;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class PokemonsSpecieController extends AbstractController
{
    #[Route('/pokemonSpecies', name: 'app_pokemons')]
    public function index(Request $request, EntityManagerInterface  $entityManager): Response
    {
        $pokemonRepo = $entityManager->getRepository(PokemonSpecie::class);
        $dresseurRepo = $entityManager->getRepository(Dresseur::class);
//        exit();
        $dresseur= $dresseurRepo->findAll();

        return $this->render('main/pokemons.html.twig', [
            'dresseurs' => $dresseur
        ]);
    }

    #[Route('/formPoke', name: 'app_pokemons_create')]
    public function new(Request $request, EntityManagerInterface  $entityManager): Response
    {
        $pokemon = new PokemonSpecie();

        $form = $this->createForm(PokemonsAddFormType::class, $pokemon);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pokemon = $form->getData();
            $entityManager->persist($pokemon);
            $entityManager->flush();
        }


        return $this->render('main/formPoke.html.twig', [
            'formPoke' => $form->createView()
        ]);
    }

    #[Route('/pokemon/modif/{id}', name: 'pokemon_update')]
    public function modifPoke(int $id, Request $request, EntityManagerInterface  $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $pokemon = $entityManager->getRepository(PokemonSpecie::class)->find($id);

        $form = $this->createForm(PokemonsAddFormType::class, $pokemon);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pokemon = $form->getData();
//            $entityManager->persist($pokemon);
            $entityManager->flush();
            $this->redirectToRoute('app_main');

        }


        return $this->render('main/modifPoke.html.twig', [
            'modifPoke' => $form->createView()
        ]);
    }

    #[Route('/pokemon/delete/{id}', name: 'pokemon_delete')]
    public function delete(int $id, EntityManagerInterface  $entityManager) : Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $pokemon = $entityManager->getRepository(PokemonSpecie::class)->find($id);

        if (!$pokemon) {
            throw $this->createNotFoundException('Pokemon non trouvé');
        }

        $entityManager->remove($pokemon);
        $entityManager->flush();

        return $this->redirectToRoute('app_main');
    }


    #[Route('/showPoke/{id}', name: 'show_pokemons')]
    public function affichagePokemons(int $id, CallPokeApi $callPokeApi): Response
    {

//        dd($callPokeApi->getPokedexId($id));
        return $this->render('main/showPoke.html.twig', [
            'pokedexNum' => $callPokeApi->getPokedexId($id),
        ]);
    }
    #[Route('/showPokeGen/{id}', name: 'show_gen')]
    public function affichageGeneration(int $id, CallPokeApi $callPokeApi): Response
    {

//        dd($callPokeApi->getGen($id));
        return $this->render('main/showPokeGen.html.twig', [
            'generation' => $callPokeApi->getGen($id),
        ]);
    }

}
