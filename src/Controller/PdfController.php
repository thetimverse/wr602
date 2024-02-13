<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PdfController extends AbstractController
{
    #[Route('/pdf', name: 'pdf_generated_success')]
    public function generatePdf(): Response
    {
        return new Response('pdf', 200, [
            'Content-Type' => 'application/pdf',
        ]);
        // return $this->render('pdf/index.html.twig', [
        //     'controller_name' => 'PdfController',
        // ]);
    }
}
