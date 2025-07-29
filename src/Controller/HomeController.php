<?php

declare(strict_types=1);

namespace App\Controller;

use App\Factory\GenreFactory;
use App\Repository\GenreRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
    GenreRepository $genreRepository,
    PostRepository $postRepository
    ): Response
    {
        $lastPost = $postRepository->findBy(
        [],
            ['CreatedAt' => 'DESC'],
            4);
        $titlepost = $postRepository->findBy(
            [],
            ['CreatedAt' => 'DESC'],
        10);


        return $this->render('home/index.html.twig', [
            'lastPost' => $lastPost,
            'titlePost' => $titlepost
        ]);
    }
}
