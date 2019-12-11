<?php

namespace App\DataFixtures\ORM;

use App\Entity\User;
use App\DataFixtures\AppFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setUsername('plumbum');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword(password_hash('mubmulp', PASSWORD_BCRYPT));
        $manager->persist($user);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AppFixtures::class,
        ];
    }
}
