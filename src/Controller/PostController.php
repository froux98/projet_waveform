<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentsForm;
use App\Repository\CommentRepository;
use App\Repository\GenreRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


final class PostController extends AbstractController
{
    #[Route('/article/{id}', name: 'app_show_post')]
    public function show(
        int $id,
        PostRepository $postRepository,
        CommentRepository $commentRepository,
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response
    {
        $post = $postRepository->findOneBy(['id' => $id], ['CreatedAt' => 'DESC']);
        if ($post === null) {
            return $this->redirectToRoute('not_found');
        }
        $comments = $commentRepository->findBy(['post' => $post ], ['createdAt' => 'DESC'], 8);

        $user = $this->getUser();
        $comment = new Comment();
        $form = $this->createForm(CommentsForm::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($user === null) {
                return $this->redirectToRoute('app_login');
            }
            $comment->setPost($post);
            $comment->setUser($user);
            $comment->setCreatedAt(new \DateTime());
            $entityManager->persist($comment);
            $entityManager->flush();
        }

        return $this->render('post/index.html.twig', [
            'posts' => $post,
            'users' => $user,
            'comments' => $comments,
            'commentForm' => $form->createView(),
        ]);
    }

    #[Route('/article/{id}/get-next-comments', name: 'app_next_comments')]
    public function nextComments(
        string $id,
        Request $request,
        CommentRepository $commentRepository,
        PaginatorInterface $paginator
    ): JsonResponse
    {
        $comments = $paginator->paginate(
            $commentRepository->getQbByCreatedAt($id),
            $request->query->getInt('page', 2),
            8
        );

        $html = '';
        foreach ($comments as $comment) {
            $html .= $this->renderView('partials/_loop_card_comment.html.twig', ['comment' => $comment]);
        }

        return new JsonResponse([
            'html' => $html,
            'hideButton' => count($comments) < 8,
        ]);
    }
}
