<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationForm;
use App\Security\AppCustomAuthenticator;
use App\Service\FileUploaderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager,FileUploaderService $fileUploaderService): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */

            $filename = $fileUploaderService->uploadFile(
                $form->get('path_pic_profile')->getData(),
                '/pathPicProfile'
            );
            $user->setPathPicProfile($filename);
            $user->setPassword($userPasswordHasher->hashPassword($user, $user->getPassword()));

            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_login');

            // do anything else you need here, like send an email
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,

        ]);
    }
}
