<?php

namespace App\Controller;

use App\Entity\Dresseur;
use App\Form\DresseurAddFormType;
use App\Repository\DresseurRepository;
use App\Trait\DresseurTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormTypeInterface;

class DresseurController extends AbstractController
{
    use DresseurTrait;

//
//    #[Route('/dresseur/{id}', name: 'app_dresseur')]
//    public function index(DresseurRepository $dresseurRepository , int $id ): Response
//    {
//        $dresseur = $dresseurRepository->find($id);
////        exit();
//
//        return $this->render('dresseur/accueil.html.twig', [
//            'dresseurs' => $dresseur
//
//        ]);
//    }
//
    #[Route('/dresseur/{name}', name: 'app_dresseur')]
    public function index(DresseurRepository $dresseurRepository, ?string $name = null): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        if (!$name) {
            $name = $this->getDresseur()->getName();
        }

        if (!$dresseur = $dresseurRepository->findTestage($name)) {
            throw $this->createNotFoundException('Le dresseur n\'existe pas');
        }
//        exit();
        return $this->render('dresseur/index.html.twig', [
            'dresseur' => $dresseur

        ]);
    }

    #[Route('/formDresseur', name: 'app_dresseurs_create')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $dresseur = new Dresseur();

        $formDresseur = $this->createForm(DresseurAddFormType::class, $dresseur);

        $formDresseur->handleRequest($request);
        if ($formDresseur->isSubmitted() && $formDresseur->isValid()) {
            $dresseur = $formDresseur->getData();
            $entityManager->persist($dresseur);
            $entityManager->flush();
        }


        return $this->render('main/formDresseur.html.twig', [
            'formDresseur' => $formDresseur->createView()
        ]);
    }

    #[Route('/dresseur/modif/{id}', name: 'dresseur_update', priority: 10)]
    public function modifdresseur(Request $request, EntityManagerInterface $entityManager, ?int $id = null): Response
    {

        if (!$id) {
            $id = $this->getDresseur()->getId();
        }
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        $dresseur = $entityManager->getRepository(Dresseur::class)->find($id);

        $form = $this->createForm(DresseurAddFormType::class, $dresseur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $dresseur = $form->getData();
//            $entityManager->persist($dresseur);
            $entityManager->flush();
            $this->redirectToRoute('app_main_accueil');
        }


        return $this->render('main/modifDresseur.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/dresseur/delete/{id}', name: 'dresseur_delete')]
    public function delete(int $id, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        $dresseur = $entityManager->getRepository(Dresseur::class)->find($id);

        if (!$dresseur) {
            throw $this->createNotFoundException('Dresseur non trouvé');
        }

        $entityManager->remove($dresseur);
        $entityManager->flush();

        $this->addFlash('message', 'Dresseur supprimé');
        return $this->redirectToRoute('app_main_accueil');
    }

    #[Route('/dresseur/type/{type}', name: 'dresseur_using_type')]
    public function getUsingType(string $type, EntityManagerInterface $entityManager): Response
    {
        $type = $entityManager->getRepository(Dresseur::class)->findByType($type);
        dump($type);
        exit();
//        if (!$type) {
//            throw $this->createNotFoundException('Type non trouvé');
//        }
//
//        return $this->render('types.html.twig', [
//            'Type' => $type

        ]);
    }
}
