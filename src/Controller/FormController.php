<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\ApiService;

class FormController extends AbstractController
{
    private $pdfService;

    public function __construct(ApiService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    #[Route('/form', name: 'app_form')]
    public function index(Request $request): Response
    {
        // Créer le formulaire
        $form = $this->createFormBuilder()
            ->add('url', null, ['required' => true])
            ->getForm();

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer l'URL saisie à partir des données du formulaire
            $url = $form->getData()['url'];

            // Faites appel à votre service pour générer le PDF
            $pdf = $this->pdfService->generatePdfFromUrl($url);

            return new Response($pdf, 200, [
                'Content-Type' => 'application/pdf',
            ]);
        }

        // Afficher le formulaire
        return $this->render('form/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
