<?php
// tests/Entity/UserTest.php
namespace App\Tests;

use App\Entity\Subscription;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class SubTest extends TestCase
{
    public function testGetterAndSetter()
    {
        // Création d'une instance de l'entité User
        $sub = new Subscription();
        
        // Définition de données de test
        $title = 'Test';
        $price = 9.99;
        $description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque tempus dapibus felis, vitae consectetur turpis vulputate ac. Mauris eget mauris ut tellus congue convallis sit amet id elit.';
        $media = 'image.jpg';
        $pdfLimit = 10;
        $user = new User();

        // Utilisation des setters
        $sub->setTitle($title)
            ->setPrice($price)
            ->setDescription($description)
            ->setMedia($media)
            ->setPdfLimit($pdfLimit)
            ->addUser($user);

        // Vérification des getters
        $this->assertEquals($title, $sub->getTitle());
        $this->assertEquals($price, $sub->getPrice());
        $this->assertEquals($description, $sub->getDescription());
        $this->assertEquals($media, $sub->getMedia());
        $this->assertEquals($pdfLimit, $sub->getPdfLimit());

        // Pour vérifier les users, on s'attend à ce qu'ils soient stockés dans une Collection
        $this->assertInstanceOf(ArrayCollection::class, $sub->getUsers());
        $this->assertTrue($sub->getUsers()->contains($user));

        // Test removeUser
        $sub->removeUser($user);
        $this->assertFalse($sub->getUsers()->contains($user));
    }
}