<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\ApiService;
use App\Entity\Pdf;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use App\Repository\PdfRepository;

class FormController extends AbstractController
{
    private $pdfService;

    public function __construct(ApiService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    #[Route('/pdf-generate', name: 'app_pdf_generate')]
    public function index(Request $request, EntityManagerInterface $entityManager, PdfRepository $pdfRepository): Response
    {
        $user = $this->getUser();

        // Créer le formulaire
        $form = $this->createFormBuilder()
            ->add('title', TextType::class)
            ->add('url', UrlType::class, ['required' => true])
            ->add('generate', SubmitType::class, ['label' => 'Generate PDF'])
            ->getForm();

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer l'URL saisie à partir des données du formulaire
            $url = $form->getData()['url'];
            $title = $form->getData()['title'];

            // Faites appel à votre service pour générer le PDF
            $newPdf = $this->pdfService->generatePdfFromUrl($url);

            $pdfFileName = uniqid() . '.pdf'; // Générez un nom de fichier unique
            $pdfFilePath = 'pdf/' . $pdfFileName; 
            $pdfFullPath = $this->getParameter('kernel.project_dir') . '/public/' . $pdfFilePath;
    
            file_put_contents($pdfFullPath, $newPdf); 
    
            $pdf = new Pdf();
            $pdf->setCreatedAt(new \DateTimeImmutable());
            $pdf->setTitle($title);
            $pdf->setFilePath($pdfFilePath); 
    
            if ($this->getUser()) {
                $pdf->setUserId($this->getUser());
            }
    
            $entityManager->persist($pdf);
            $entityManager->flush();

            // LIMIT
            $subscription = $user->getSubscription();

            $startOfDay = new \DateTime("today", new \DateTimeZone('UTC'));
            $endOfDay = new \DateTime("tomorrow", new \DateTimeZone('UTC'));
            $endOfDay->modify('-1 second'); 

            $pdfCountToday = $pdfRepository->findPdfGeneratedByUserOnDate($user->getId(), $startOfDay, $endOfDay);

            if ($subscription && $pdfCountToday >= $subscription->getPdfLimit()) {
                $this->addFlash('error', 'You have reached the daily limit of your subscription for the number of PDFs generated.');
                return $this->redirectToRoute('app_pdf_generate');
            } else {
                return new Response($newPdf, 200, [
                    'Content-Type' => 'application/pdf',
                ]);
            }
        }  
        
        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('error', 'Invalid URL.');
        }
        

        // Afficher le formulaire
        return $this->render('pdf_generator/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
