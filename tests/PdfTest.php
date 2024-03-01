<?php
// tests/Entity/UserTest.php
namespace App\Tests;

use App\Entity\Pdf;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class PdfTest extends TestCase
{
    public function testGetterAndSetter()
    {
        // Création d'une instance de l'entité User
        $pdf = new Pdf();
        
        // Définition de données de test
        $createdAt = new \DateTimeImmutable('now');
        $user = new User();
        $title = 'Test';
        $pdfFileName = uniqid() . '.pdf'; // Générez un nom de fichier unique
        $pdfFilePath = 'pdf/' . $pdfFileName; 
        $filepath = $this->getParameter('kernel.project_dir') . '/public/' . $pdfFilePath;

        // Utilisation des setters
        $pdf->setCreatedAt($createdAt)
            ->setUserId($user)
            ->setFilepath($filepath)
            ->setTitle($title);

        // Vérification des getters
        $this->assertEquals($createdAt, $pdf->getCreatedAt());
        $this->assertEquals($user, $pdf->getUserId());
        $this->assertEquals($filepath, $pdf->getFilepath());
        $this->assertEquals($title, $pdf->getTitle());
    }
}