<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Pdf;
use App\Entity\User;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Doctrine\ORM\EntityManagerInterface;

class HistoryController extends AbstractController
{
    #[Route('/pdf-history', name: 'app_history')]
    public function index(): Response
    {
        $user = $this->getUser();
        $pdfs = $user->getFiles();

        return $this->render('history/index.html.twig', [
            'pdfs' => $pdfs,
        ]);
    }

    #[Route('/pdf-view/{id}', name: 'app_pdf_view')]
    public function viewPdf(int $id, EntityManagerInterface $entityManager): Response
    {
        $pdfRepository = $entityManager->getRepository(Pdf::class);
        $pdf = $pdfRepository->find($id);
    
        if (!$pdf || !$this->getUser() || $pdf->getUserId() !== $this->getUser()) {
            throw $this->createNotFoundException('The file does not exist or you do not have permission to view it.');
        }
    
        $pdfFilePath = $this->getParameter('kernel.project_dir') . '/public/' . $pdf->getFilepath();
    
        if (!file_exists($pdfFilePath)) {
            throw $this->createNotFoundException('The file does not exist.');
        }
    
        return $this->file($pdfFilePath, null, ResponseHeaderBag::DISPOSITION_INLINE);
    }

    #[Route('/pdf-delete/{id}', name: 'app_pdf_delete')]
    public function deletePdf(int $id, EntityManagerInterface $entityManager): Response
    {
        $pdfRepository = $entityManager->getRepository(Pdf::class);
        $pdf = $pdfRepository->find($id);
    
        // the file exists and the user is allowed to delete it
        if (!$pdf || $pdf->getUserId() !== $this->getUser()) {
            $this->addFlash('error', 'You do not have the permissions to delete this file.');
            return $this->redirectToRoute('app_history');
        }
    
        $entityManager->remove($pdf);
        $entityManager->flush();
    
        $this->addFlash('success', 'The PDF was successfully deleted.');
    
        return $this->redirectToRoute('app_history');
    }
}
