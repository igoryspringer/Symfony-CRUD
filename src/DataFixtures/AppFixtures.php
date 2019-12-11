<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; ++$i) {
            $article = new Article();
            $article->setName('test'.$i);
            $article->setDescription(mt_rand(100, 1000));
            $article->setCreatedAt(new \DateTime());
            $manager->persist($article);
        }
        $manager->flush();
    }
}
