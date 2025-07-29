<?php

namespace App\Twig\Runtime;

use App\Repository\GenreRepository;
use Twig\Extension\RuntimeExtensionInterface;

readonly class GenreExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(private GenreRepository $genreRepository)
    {
    }

    public function getGenres(): array
    {
        return $this->genreRepository->findBy([], ['type' => 'ASC']);
    }
}
