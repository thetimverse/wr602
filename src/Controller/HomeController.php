<?php

namespace App\Controller;

use App\Repository\SubscriptionRepository;
use App\Repository\PdfRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(SubscriptionRepository $subscriptionRepository, PdfRepository $pdfRepository): Response
    {
        $subscriptions = $subscriptionRepository->findAll();
        $user = $this->getUser();
        $pdfCountToday = 0;
        $now = new \DateTime('now', new \DateTimeZone('UTC'));
        $endOfDay = new \DateTime("tomorrow", new \DateTimeZone('UTC'));
        $endOfDay->modify('-1 second');

        $timeLeft = $endOfDay->getTimestamp() - $now->getTimestamp();

        if ($user) {
            $startOfDay = new \DateTime("today", new \DateTimeZone('UTC'));
            $endOfDay = new \DateTime("tomorrow", new \DateTimeZone('UTC'));
            $endOfDay->modify('-1 second');
            $now = new \DateTime('now', new \DateTimeZone('UTC'));

            $pdfCountToday = $pdfRepository->findPdfGeneratedByUserOnDate($user->getId(), $startOfDay, $endOfDay);
        }

        return $this->render('home/index.html.twig', [
            'subscriptions' => $subscriptions,
            'user' => $user,
            'pdfCountToday' => $pdfCountToday,
            'timeLeft' => $timeLeft,
        ]);
    }
}
