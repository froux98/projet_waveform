<?php

namespace App\DataFixtures;

use App\Factory\CommentFactory;
use App\Factory\GenreFactory;
use App\Factory\LikeFactory;
use App\Factory\PostFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        UserFactory::createMany(30);
        GenreFactory::createOne(['type' => "House"]);
        GenreFactory::createOne(['type' => "Bass Music"]);
        GenreFactory::createOne(['type' => "Trance"]);
        GenreFactory::createOne(['type' => "Techno"]);
        GenreFactory::createOne(['type' => "Hardstyle"]);
        GenreFactory::createOne(['type' => "Pop"]);
        GenreFactory::createOne(['type' => "Album"]);
        GenreFactory::createOne(['type' => "Mixs"]);
        PostFactory::createMany(15);
        CommentFactory::createMany(300);
        LikeFactory::createMany(200);

        $manager->flush();
    }
}
