<?php

namespace App\DataFixtures;

use App\Entity\Coach;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CoachFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 8; $i++) {
            $coach = new Coach();
            $coach->setName($faker->name());
            $coach->setExperienceYears($faker->numberBetween(3, 30));
            $coach->setBio($faker->paragraph(3));
            $coach->setPhotoUrl('https://i.pravatar.cc/300?img=' . rand(1, 70));

            $manager->persist($coach);
        }

        $manager->flush();
    }
}
