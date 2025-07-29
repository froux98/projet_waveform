<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\GenreRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GenreController extends AbstractController
{
    #[Route('/genre/{type}', name: 'app_show_genre')]
    public function show_genres(string $type, GenreRepository $genreRepository, PostRepository $postRepository): Response
    {
        $genre = $genreRepository->findOneBy(['type' => $type]);
        $genres = $genreRepository->findAll();
        $findPostByGenre = $postRepository->findByCategory($genre);
        return $this->render('genre/index.html.twig', [
            'postGenre' => $findPostByGenre,
            'genre' => $genre,
            'genres' => $genres,
        ]);

    }
}
