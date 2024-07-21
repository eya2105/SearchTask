<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ClientFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_RR');

        for($i=0; $i<100; $i++){
            $client=new Client();
            $client->setFirstname($faker->firstName);
            $client->setLastname($faker->lastName);
            $client->setPassword($faker->password);
            $client->setEmail($faker->email);
            $manager->persist($client);
        }

        $manager->flush();
    }
}
