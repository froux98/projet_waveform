<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\LikeRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class LikeExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('has_user_liked_comment', [LikeRuntime::class, 'hasUserLikedComment']),
        ];
    }
}
