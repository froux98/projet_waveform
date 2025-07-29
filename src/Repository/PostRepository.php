<?php

namespace App\Repository;

use App\Entity\Genre;
use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use http\QueryString;

/**
 * @extends ServiceEntityRepository<Post>
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function findByCategory(Genre $genre, int $limit = null): array
    {
        $qb = $this->createQueryBuilder('g')
            ->join('g.genres', 'genre')
            ->where('genre = :genre')
            ->setParameter('genre', $genre);


        if ($limit !== null) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }

    public function getAll() : Query
    {
        return $this ->createQueryBuilder('g')
            ->orderBy('g.id', 'ASC')
            -> getQuery();

    }
}
