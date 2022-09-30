<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $f = Faker\Factory::create();

        $e = [];
        for ($i = 0; $i < 20; $i++) {
            $post = new User();
            $post->setEmail($f->email);
            $post->setUsername($f->userName);
            $post->setLastName($f->name);
            $post->setFirstName($f->name);
            $post->setPassword($f->password);
            $manager->persist($post);
            $e[$i] = $post;
        }

        $e1 = [];
        for ($i = 0; $i < 20; $i++) {
            $postp = new Post();
            $postp->setTitle($f->sentence($nbWords = 6, $variableNbWords = true));
            $postp->setAuthor($e[$f->numberBetween(0, 19)]);
            $postp->setImage($f->imageUrl($width = 640, $height = 480));
            $postp->setContent($f->text);
            $postp->setPublishedAt(new \DateTimeImmutable('tomorrow'));
            $manager->persist($postp);
            $e1[$i] = $postp;
        }

        $e2 = [];
        for ($i = 0; $i < 20; $i++) {
            $post = new Comment();
            $post->setAuthor($e[$f->numberBetween(0, 19)]);
            $post->setContent($f->text);
            $post->setPost($e1[$f->numberBetween(0, 19)]);
            $post->setCreatedAt(new \DateTimeImmutable('tomorrow'));
            $manager->persist($post);
            $e2[$i] = $post;
        }

        $manager->flush();
    }
}
