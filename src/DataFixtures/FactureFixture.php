<?php
namespace App\DataFixtures;

use App\Entity\Facture;
use App\Entity\Client;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FactureFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $clients = $manager->getRepository(Client::class)->findAll();
        $products = $manager->getRepository(Product::class)->findAll();

        if (empty($clients) || empty($products)) {
            throw new \Exception('No clients or products found in the database.');
        }

        for ($i = 0; $i < 100; $i++) {
            $facture = new Facture();
            $facture->setDescription($faker->word());
            $facture->setQuantity($faker->numberBetween(1, 100));
            $facture->setTotalPrice($faker->randomFloat(2, 10, 500));
            $facture->setClientID($faker->randomElement($clients));
            $facture->setProductID($faker->randomElement($products));

            $manager->persist($facture);
        }

        $manager->flush();
    }
}
