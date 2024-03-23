<?php

namespace App\DataFixtures;

use App\Factory\ClientFactory;
use App\Factory\InvoiceFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private const USER_COUNT = 20;
    private const USER_CLIENT = 20;
    private const USER_INVOICE = 20;
    public function load(ObjectManager $manager): void
    {
        UserFactory::createMany(self::USER_COUNT);

        ClientFactory::createMany(self::USER_CLIENT);

        InvoiceFactory::createMany(self::USER_INVOICE);

        $manager->flush();
    }
}
