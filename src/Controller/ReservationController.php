<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation')]
    public function index(Request $request, ManagerRegistry $doctrine, Security $security): Response
    {
        
        $entityManager = $doctrine->getManager();

        $reservation = new Reservation();
        $form = $this->createForm(ReservationFormType::class, $reservation);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Check if the user is logged in
            if ($this->getUser()) {
              // If the user is logged in, set the user for the reservation
              $reservation->setUser($this->getUser());
            }

            // Persist the entity
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('reservation/index.html.twig', [
            'reservationForm' => $form->createView(),
        ]);
    }
}

