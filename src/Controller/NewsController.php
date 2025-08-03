<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\GenreRepository;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NewsController extends AbstractController
{
    #[Route('/news', name: 'app_show_news')]
    public function News(
        PostRepository $postRepository,
        PaginatorInterface $paginator,
        Request $request
    ) : Response {
        $listNews = $paginator->paginate(
            $postRepository->getAll(),
            $request->query->getInt('page', 1),
            10);


        return $this->render('post/news.html.twig', [
            'posts' => $listNews,

        ]);
    }


    public function list (PostRepository $postRepository, PaginatorInterface $paginator, Request $request): Response
    {

        $listNews = $paginator->paginate(
            $postRepository->getAll(),
            $request->query->getInt('page', 1),
            10

        );
        return $this->render('post/news.html.twig', [
            'listNews' => $listNews,

        ]);
    }

    #[Route('/404_not_found', name: 'not_found')]
    public function error(GenreRepository $genreRepository): Response
    {
        $genres = $genreRepository->findAll();
        return $this->render('admin/404.html.twig', [
            'genres' => $genres,
        ]);

    }

}
