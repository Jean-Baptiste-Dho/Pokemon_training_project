<?php

namespace App\Controller;

use App\Entity\Pokemon;
use App\Form\API\PokemonFormType;
use App\Repository\PokemonRepository;
use App\Service\PokemonManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TestageController extends AbstractController
{

    private PokemonManager $pokemonManager;
    private EntityManagerInterface $entityManager;
    private SerializerInterface $serializer;

    public function __construct(PokemonManager $pokemonManager, EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $this->pokemonManager = $pokemonManager;
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    #[Route('/testage/pokemon', name: 'testage_list', methods: ['GET'])]
    public function list(PokemonRepository $repository, SerializerInterface $serializer): Response
    {
        $pokemons = $repository->findAll();
        $data = $serializer->serialize($pokemons, 'json');

        return new JsonResponse($data, 200, [], true);
    }

    #[Route('/testage/pokemon', name: 'testage_create', methods: ['POST'])]
    public function create(Request $request, SerializerInterface $serializer): Response
    {
        $pokemon = new Pokemon();
        $this->pokemonManager->assignNumber($pokemon);

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
    public function update(int $id, Request $request, PokemonRepository $repository, SerializerInterface $serializer): Response
    {
        if (!$pokemon = $repository->find($id)) {
            throw $this->createNotFoundException('pokemon not found');
        }

        return $this->processForm($pokemon, $request, false);
    }

    #[Route('/testage/pokemon/{id}', name: 'testage_delete', methods: ['DELETE'])]
    public function delete(int $id, EntityManagerInterface $em): Response
    {
        $pokemon = $em->getRepository(Pokemon::class)->find($id);

        if (is_null($pokemon)) {
            return $this->nullResponse();
        }

        $em->remove($pokemon);
        $em->flush();

        return new JsonResponse($pokemon, Response::HTTP_NO_CONTENT, [], true);
    }

    /**
     * @param Request $request
     * @param \Symfony\Component\Form\FormInterface $form
     * @return mixed
     */
    public function handleJsonRequest(Request $request, \Symfony\Component\Form\FormInterface $form): mixed
    {
        $data = $request->getContent(); // données de type string
        $data = json_decode($data, true); // données de type array

        $form->submit($data, 'PATCH' !== $request->getMethod());
        return $data;
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $form
     * @return JsonResponse
     */
    public function formErrorResponse(\Symfony\Component\Form\FormInterface $form): JsonResponse
    {
        return new JsonResponse([
            'code' => Response::HTTP_BAD_REQUEST,
            'message' => $form->getErrors()->current()->getMessage()
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $form
     * @return JsonResponse
     */
    public function nullResponse(): JsonResponse
    {
        return new JsonResponse([
            'code' => Response::HTTP_NOT_FOUND,
            'message' => 'Pas de pokémon trouvé'
        ], Response::HTTP_NOT_FOUND);
    }


    /**
     * @param Pokemon $pokemon
     * @param bool $isCreation
     * @param Request $request
     * @return JsonResponse
     */
    public function processForm(Pokemon $pokemon, Request $request, bool $isCreation): JsonResponse
    {
        if ($isCreation) {
            $statusCode = Response::HTTP_CREATED;
        } else {
            $statusCode = Response::HTTP_OK;
        }

        $form = $this->createForm(PokemonFormType::class, $pokemon);

        $this->handleJsonRequest($request, $form);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($pokemon);
            $this->entityManager->flush();

            $data = $this->serializer->serialize($pokemon, 'json');

            return new JsonResponse($data, $statusCode, [], true);
        } else {
            return $this->formErrorResponse($form);
        }
    }

}
