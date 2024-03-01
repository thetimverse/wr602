<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Subscription;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditProfileController extends AbstractController
{
    #[Route('/edit-profile', name: 'app_edit_profile')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if ($request->isMethod('POST')) {
            $firstname = $request->request->get('firstname');
            $lastname = $request->request->get('lastname');
            $subscriptionId = $request->request->get('subscription'); 

            if ($firstname) {
                $user->setFirstname($firstname);
            }

            if ($lastname) {
                $user->setLastname($lastname);
            }

            if ($subscriptionId) {
                $subscription = $entityManager->getRepository(Subscription::class)->find($subscriptionId); 
                if ($subscription) {
                    $user->setSubscription($subscription); 
                }
            }

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Your profile has been updated.');
            return $this->redirectToRoute('app_edit_profile');
        }

        $subscriptions = $entityManager->getRepository(Subscription::class)->findAll();

        return $this->render('edit_profile/index.html.twig', [
            'user' => $user,
            'subscriptions' => $subscriptions, 
        ]);
    }
}
