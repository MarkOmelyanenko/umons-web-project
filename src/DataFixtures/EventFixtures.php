<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EventFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $start = $faker->dateTimeBetween('-10 days', '+30 days');
            $end = (clone $start)->modify('+2 hours');

            $event = new Event();
            $event->setTitle($faker->sentence(3));
            $event->setDescription($faker->paragraph(3));
            $event->setLocation($faker->city());
            $event->setCreatedAt(new \DateTimeImmutable());
            $event->setStartAt(\DateTimeImmutable::createFromMutable($start));
            $event->setEndAt(\DateTimeImmutable::createFromMutable($end));
            $event->setMaxParticipants($faker->numberBetween(5, 15));

            $manager->persist($event);
            $this->addReference('event_' . $i, $event);
        }

        $manager->flush();
    }
}
