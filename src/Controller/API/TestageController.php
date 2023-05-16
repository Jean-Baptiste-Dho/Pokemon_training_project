<?php

namespace App\Controller\API;

use App\Controller\AbstractRestController;
use App\Entity\Pokemon;
use App\Form\API\PokemonFormType;
use App\Repository\PokemonRepository;
use App\Service\PokemonManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api')]
class TestageController extends AbstractRestController
{
    protected $formClass = PokemonFormType::class;
    private PokemonManager $pokemonManager;

    #[Route('/testage/pokemon', name: 'testage_list', methods: ['GET'])]
    public function list(PokemonRepository $repository): Response
    {
        return $this->listAbstract($repository);
    }

    #[Route('/testage/pokemon', name: 'testage_create', methods: ['POST'])]
    public function create(Request $request, PokemonManager $pokemonManager): Response
    {

        $pokemon = new Pokemon();
        $pokemonManager->assignNumber($pokemon);

        return $this->processForm($pokemon, $request, true);
    }

    #[Route('/testage/pokemon/{id}', name: 'testage_get', methods: ['GET'])]
    public function get(int $id, PokemonRepository $repository, SerializerInterface $serializer): Response
    {
        if (!$pokemon = $repository->find($id)) {
            throw $this->createNotFoundException('pokemon not found');
        }

        $data = $serializer->serialize($pokemon, 'json');

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route('/testage/pokemon/{id}', name: 'testage_patch', methods: ['PATCH'])]
    public function update(int $id, Request $request, PokemonRepository $repository): Response
    {
        if (!$pokemon = $repository->find($id)) {
            throw $this->createNotFoundException('pokemon not found');
        }

        return $this->processForm($pokemon, $request, false);
    }

    #[Route('/testage/pokemon/{id}', name: 'testage_delete', methods: ['DELETE'])]
    public function delete(int $id, EntityManagerInterface $entityManager): Response
    {
        $pokemon = $entityManager->getRepository(Pokemon::class)->find($id);

        if (is_null($pokemon)) {
            return $this->nullResponse();
        }

        $entityManager->remove($pokemon);
        $entityManager->flush();

        return new JsonResponse($pokemon, Response::HTTP_NO_CONTENT, [], true);
    }
}
