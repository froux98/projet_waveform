<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Like;
use App\Entity\User;
use App\Repository\CommentRepository;
use App\Repository\LikeRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CommentsController extends AbstractController
{
    #[Route('/comments/like_comment/{id}', name: 'app_show_comment_like', methods: ['POST'])]
    public function likeComments(
        string $id,
        CommentRepository $commentRepository,
        LikeRepository $likeRepository,
        EntityManagerInterface $entityManager,
        UrlGeneratorInterface $generator
    ): JsonResponse
    {
        $comment = $commentRepository->findOneBy(['id' => $id]);
        /** @var User|null $user */
        $user = $this->getUser();
        if (!$user) {
            return new JsonResponse($generator->generate('app_login'));
        }

        $like = $likeRepository->findOneBy(['user' => $user, 'comment' => $comment]);
        $code = 200;
        if ($like !== null) {
            $entityManager->remove($like);
            $code = 100;
        } else {
            $like = (new Like())
                ->setComment($comment)
                ->setUser($user)
                ->setCreatedAt(new \DateTime());

            $entityManager->persist($like);
        }

        $entityManager->flush();

        return new JsonResponse($code);
    }
}
