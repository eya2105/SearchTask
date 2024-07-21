<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR'); // Correct locale

        for ($i = 0; $i < 100; $i++) {
            $product = new Product();
            $product->setName($faker->word); // Ensure name is a word
            $product->setDescription($faker->word); // Use sentence for description
            $product->setPrice($faker->randomFloat(2, 10, 1000)); // Use randomFloat for realistic price
            $product->setStock($faker->numberBetween(1, 100)); // Use numberBetween for stock range

            $manager->persist($product);
        }

        $manager->flush();
    }
}
