<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Entity\User;
use App\Form\AddPostForm;
use App\Form\RegistrationForm;
use App\Repository\PostRepository;
use App\Service\FileUploaderService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    #[Route('/admin/posts', name: 'admin_posts')]
    public function index(
        PostRepository $postRepository,
        PaginatorInterface $paginator,
        Request $request): Response
    {
        $listNews = $paginator->paginate(
            $postRepository->getAll(),
            $request->query->getInt('page', 1),
            10);
        return $this->render('admin/index.html.twig', [
            'posts' => $listNews,
        ]);
    }
    #[Route('/admin/posts/add', name: 'admin_add_post',methods: ['GET', 'POST'])]
    public function addPost(
        Request $request,
        FileUploaderService $fileUploaderService,
        EntityManagerInterface $entityManager,
    ): Response
    {
        $post = new Post();
        $form = $this->createForm(AddPostForm::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $filename = $fileUploaderService->uploadFile(
                $form->get('pathPicPost')->getData(),
                '/pathPicPost'
            );
            $post->setPathPicPost($filename);
            $post->setUser($this->getUser());
            $post->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($post);
            $entityManager->flush();
            return $this->redirectToRoute('admin_posts');
        }
        return $this->render('admin/addPost.html.twig', [
            'addPostForm' => $form->createView(),
        ]);
    }
    #[Route('/admin/posts/edit/{id}', name: 'admin_edit_post',methods: ['GET', 'POST'])]
    public function editPost(
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        PostRepository $postRepository
    ): Response
    {
        $post = $postRepository ->findOneBy (['id' => $id]);
        $form = $this->createForm(AddPostForm::class, $id);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($post);
            $entityManager->flush();
            return $this->redirectToRoute('');
        }
        return $this->render('admin/index.html.twig', [
            'addPostForm' => $form->createView(),
        ]);
    }

    #[Route('/admin/game/{id}/delete', name: 'admin_delete_post',methods: ['GET', 'POST'])]
    public function delete (PostRepository $postRepository, int $id, EntityManagerInterface $em): Response
    {
        $post = $postRepository ->findOneBy (['id' => $id]);
        $em -> remove($post);
        $em ->flush();

        return $this->redirectToRoute('admin_posts');

    }


}








