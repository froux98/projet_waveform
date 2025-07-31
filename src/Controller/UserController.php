<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/mon_profil', name: 'app_profil', methods: ['GET'])]
    public function profil(
    ): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        return $this->render('user/user.html.twig', [
            'user' => $user,
        ]);

    }
}
