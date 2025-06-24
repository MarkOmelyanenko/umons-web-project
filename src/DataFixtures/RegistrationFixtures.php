<?php

namespace App\DataFixtures;

use App\Entity\Registration;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RegistrationFixtures extends Fixture implements DependentFixtureInterface {

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 25; $i++) {
            $user = $this->getReference('user_' . $i, \App\Entity\User::class);

            $eventCount = random_int(1, 3);
            $usedEventIds = [];

            for ($j = 0; $j < $eventCount; $j++) {
                $eventId = random_int(0, 9);
                if (in_array($eventId, $usedEventIds)) continue;
                $usedEventIds[] = $eventId;

                $event = $this->getReference('event_' . $eventId, \App\Entity\Event::class);

                $registration = new Registration();
                $registration->setUser($user);
                $registration->setEvent($event);
                $registration->setRegisteredAt(new \DateTimeImmutable());

                $manager->persist($registration);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            EventFixtures::class,
        ];
    }
}
