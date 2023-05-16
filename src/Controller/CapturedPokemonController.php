<?php

namespace App\Controller;

use App\Entity\Dresseur;
use App\Entity\CapturedPokemon;
use App\Form\CapturedPokemonFormType;
use App\Security\Voter\PokemonVoter;
use App\Service\CallPokeApi;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CapturedPokemonController extends AbstractController
{
    #[Route('/pokemonSpecies', name: 'app_pokemons')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $dresseurRepo = $entityManager->getRepository(Dresseur::class);
        $dresseur = $dresseurRepo->findAll();

        return $this->render('/main/pokemons.html.twig', [
            'dresseurs' => $dresseur
        ]);
    }

    #[Route('/formPoke', name: 'pokemon_create')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pokemon = new CapturedPokemon();
        $pokemon->setDresseur($this->getUser());

        $form = $this->createForm(CapturedPokemonFormType::class, $pokemon);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pokemon = $form->getData();
            $entityManager->persist($pokemon);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Vous avez capturé un ' . $pokemon . ' sauvage ! Félicitations !!'
            );


            return $this->redirectToRoute('app_main_accueil');
        }

        return $this->render('main/formPoke.html.twig', [
            'formPoke' => $form->createView()
        ]);
    }

    #[Route('/pokemon/modif/{id}', name: 'pokemon_update')]
    public function modifPoke(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $pokemon = $entityManager->getRepository(CapturedPokemon::class)->find($id);
        $this->denyAccessUnlessGranted(PokemonVoter::UPDATE, $pokemon);

        $form = $this->createForm(CapturedPokemonFormType::class, $pokemon);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pokemon = $form->getData();
//            $entityManager->persist($pokemon);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Pokémon mis à jour avec succès !'
            );


            return $this->redirectToRoute('app_main_accueil');
        }


        return $this->render('main/modifPoke.html.twig', [
            'modifPoke' => $form->createView()
        ]);
    }

    #[Route('/pokemon/delete/{id}', name: 'pokemon_delete')]
    public function delete(int $id, EntityManagerInterface $entityManager): Response
    {
        $pokemon = $entityManager->getRepository(CapturedPokemon::class)->find($id);
        $this->denyAccessUnlessGranted(PokemonVoter::DELETE, $pokemon);

        if (!$pokemon) {
            throw $this->createNotFoundException('Pokemon non trouvé');
        }

        $entityManager->remove($pokemon);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Vous avez relaché votre ' . $pokemon . ' dans la nature !'
        );


        return $this->redirectToRoute('app_main_accueil');
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
