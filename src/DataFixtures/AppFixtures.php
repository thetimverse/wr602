<?php

namespace App\DataFixtures;

use App\Entity\Subscription;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $sub1 = new Subscription();
        $sub1->setTitle('Free');
        $sub1->setPrice(0);
        $sub1->setDescription('With the Free subscription, you can generate 2 PDFs from a URL per day. Test our service now.');
        $sub1->setPdfLimit(2);
        $manager->persist($sub1);

        $sub2 = new Subscription();
        $sub2->setTitle('Premium');
        $sub2->setPrice(9.99);
        $sub2->setDescription('The Premium subscription allows you to generate 6 PDFs each day.');
        $sub2->setPdfLimit(6);
        $manager->persist($sub2);

        $sub3 = new Subscription();
        $sub3->setTitle('Ultra');
        $sub3->setPrice(19.99);
        $sub3->setDescription('The Ultra subscription allows you to generate 50 PDFs each day.');
        $sub3->setPdfLimit(50);
        $manager->persist($sub3);

        $manager->flush();
    }
}
