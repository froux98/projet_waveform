<?php

namespace App\Twig\Runtime;

use App\Entity\Comment;
use App\Entity\User;
use Twig\Extension\RuntimeExtensionInterface;

class LikeRuntime implements RuntimeExtensionInterface
{

    public function hasUserLikedComment(?User $user, Comment $comment): bool
    {
        if ($user === null) {
            return false;
        }
        foreach ($user->getLikes() as $like) {
            if ($like->getComment()->getId() === $comment->getId()) {
                return true;
            }
        }
        return false;
    }
}
