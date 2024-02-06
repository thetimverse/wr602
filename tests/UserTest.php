<?php
// tests/Entity/UserTest.php
namespace App\Tests;

use App\Entity\PDF;
use App\Entity\Subscription;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGetterAndSetter()
    {
        // Création d'une instance de l'entité User
        $user = new User();
        
        // Définition de données de test
        $email = 'test@test.com';
        $roles = ['ROLE_USER', 'ROLE_ADMIN'];
        $password = 'password123';
        $lastname = 'DOE';
        $firstname = 'John';
        $subscriptionEndAt = new \DateTime('+1 year');
        $createdAt = new \DateTimeImmutable('now');
        $updatedAt = new \DateTime('now');
        $subscription = new Subscription();
        $pdf = new PDF();

        // Utilisation des setters
        $user->setEmail($email)
            ->setRoles($roles)
            ->setPassword($password)
            ->setLastname($lastname)
            ->setFirstname($firstname)
            ->setSubscriptionEndAt($subscriptionEndAt)
            ->setCreatedAt($createdAt)
            ->setUpdatedAt($updatedAt)
            ->setSubscription($subscription)
            ->addFile($pdf);

        // Vérification des getters
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($roles, $user->getRoles());
        $this->assertEquals($password, $user->getPassword());
        $this->assertEquals($firstname, $user->getFirstname());
        $this->assertEquals($lastname, $user->getLastname());
        $this->assertEquals($subscriptionEndAt, $user->getSubscriptionEndAt());
        $this->assertEquals($createdAt, $user->getCreatedAt());
        $this->assertEquals($updatedAt, $user->getUpdatedAt());
        $this->assertEquals($subscription, $user->getSubscription());

        // Pour vérifier les PDFs, on s'attend à ce qu'ils soient stockés dans une Collection
        $this->assertInstanceOf(ArrayCollection::class, $user->getFiles());
        $this->assertTrue($user->getFiles()->contains($pdf));

        // Test removePdf
        $user->removeFile($pdf);
        $this->assertFalse($user->getFiles()->contains($pdf));
    }
}