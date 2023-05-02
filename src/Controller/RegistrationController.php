<?php

namespace App\Controller;

use App\Entity\Dresseur;
use App\Form\RegistrationFormType;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $dresseurAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $dresseur = new Dresseur();
        $form = $this->createForm(RegistrationFormType::class, $dresseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $dresseur->setPassword(
                $userPasswordHasher->hashPassword(
                    $dresseur,
                    $form->get('plainPassword')->getData()
                )
            );
            
            $entityManager->persist($dresseur);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $dresseurAuthenticator->authenticateUser(
                $dresseur,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
