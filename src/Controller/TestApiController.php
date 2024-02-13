<?php

namespace App\Controller;

use App\Service\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestApiController extends AbstractController
{
    #[Route('/test/api', name: 'app_test_api')]
    public function new(ApiService $testApiService): Response
    {
        //génération de l'index.html
        $url = [
            'url' => 'https://docs.mmi-troyes.fr/'
        ];

        //utilisation du service Gotenberg, en lui transmettant l'url afin de récupérer l'index.html
        $convertion = $testApiService->generatePdfFromUrl($url);


        return new Response($convertion, 200, [
            'Content-Type' => 'application/pdf',
        ]);

        // return $this->render('test_api/index.html.twig', [
        //     'controller_name' => 'TestApiController',
        // ]);
    }
}
