<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class BlogPostFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $post = new BlogPost();
            $post->setTitle($faker->sentence(6));
            $post->setAuthor($faker->name());
            $post->setContent($faker->paragraphs(4, true));
            $post->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 year', 'now')));
            $post->setImageUrl('https://picsum.photos/seed/' . uniqid() . '/800/400');

            $manager->persist($post);
        }

        $manager->flush();
    }
}
