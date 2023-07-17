<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
            
            // Retrieve the selected date from the submitted form data
            $selectedDate = $reservation->getDate();
                    
            // Define the specific lunch hours to check
            $selectedLunchHours = ['12:00', '12:15', '12:30', '13:00', '13:15', '13:30', '13:45'];
                    
            // Define the specific dinner hours to check
            $selectedDinnerHours = ['19:00', '19:15', '19:30', '19:45', '20:00', '20:15', '20:30', '20:45'];
                    
            // Count existing reservations for the given date and specific lunch hours
            $existingLunchCount = $entityManager
                ->getRepository(Reservation::class)
                ->countReservationsByDateAndHours($selectedDate, $selectedLunchHours);
                    
            // Count existing reservations for the given date and specific dinner hours
            $existingDinnerCount = $entityManager
                ->getRepository(Reservation::class)
                ->countReservationsByDateAndHours($selectedDate, $selectedDinnerHours);
                    
            // Set your desired capacity limits for lunch and dinner
            $lunchCapacityLimit = 3;
            $dinnerCapacityLimit = 2;
                    
            // Check if the lunch count exceeds the limit
            if ($existingLunchCount >= $lunchCapacityLimit) {
                $this->addFlash('error', 'Désolé, les heures de déjeuner sélectionnées sont entièrement réservées. Veuillez choisir un horaire différent.');
                return $this->redirectToRoute('app_reservation');
            }
            
            // Check if the dinner count exceeds the limit
            if ($existingDinnerCount >= $dinnerCapacityLimit) {
                $this->addFlash('error', 'Désolé, les heures de dîner sélectionnées sont entièrement réservées. Veuillez choisir un horaire différent.');
                return $this->redirectToRoute('app_reservation');
            }

    
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