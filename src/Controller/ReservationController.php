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

            // Define the specific hours to check
            $selectedHours = ['12:00', '12:15', '12:30'];

            // Count existing reservations for the given date and specific hours
            $existingCount = $entityManager
                ->getRepository(Reservation::class)
                ->countReservationsByDateAndHours($selectedDate, $selectedHours);

            // Set your desired capacity limit
            $capacityLimit = 50;

        // Check if the count exceeds the limit
        if ($existingCount >= $capacityLimit) {
              $this->addFlash('error', 'Sorry, the selected date and hours are fully booked. Please choose a different time.');
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