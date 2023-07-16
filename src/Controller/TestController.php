<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Schedule;
use App\Form\ReservationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(EntityManagerInterface $entityManager, Request $request, Security $security): Response
    {
        // Fetch the schedule object
        $schedule = $entityManager->getRepository(Schedule::class)->findOneBy(['day' => 'Lundi']);

        if (!$schedule) {
            throw $this->createNotFoundException('Schedule not found.');
        }

        // Get the lunch opening and closing times
        $lunchOpeningTime = $schedule->getLunchOpening();
        $lunchClosingTime = $schedule->getLunchClosing();

        // Get the dinner opening and closing times
        $dinnerOpeningTime = $schedule->getDinnerOpening();
        $dinnerClosingTime = $schedule->getDinnerClosing();

        // Create the form and handle the request
        $timeRanges = $this->generateTimeRange($lunchOpeningTime, $lunchClosingTime, $dinnerOpeningTime, $dinnerClosingTime);
        $form = $this->createForm(ReservationFormType::class, null, [
            'timeRangeLunch' => $timeRanges['lunch'],
            'timeRangeDinner' => $timeRanges['dinner'],
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Retrieve the selected date from the submitted form data
            $selectedDate = $reservation->getDate();

            // Define the specific hours to check
            $selectedHours = array_keys($timeRanges['lunch']);
            $selectedHours = array_merge($selectedHours, array_keys($timeRanges['dinner']));

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

    private function generateTimeRange(\DateTimeInterface $lunchOpeningTime, \DateTimeInterface $lunchClosingTime, \DateTimeInterface $dinnerOpeningTime, \DateTimeInterface $dinnerClosingTime): array
    {
        $timeRangeLunch = [];
        $currentLunchTime = clone $lunchOpeningTime;
        $closingLunchTime = clone $lunchClosingTime;
        $closingLunchTime->modify('-1 hour');

        $timeRangeDinner = [];
        $currentDinnerTime = clone $dinnerOpeningTime;
        $closingDinnerTime = clone $dinnerClosingTime;
        $closingDinnerTime->modify('-1 hour');

        $interval = new \DateInterval('PT15M');

        while ($currentLunchTime < $closingLunchTime) {
            $timeRangeLunch[$currentLunchTime->format('H:i')] = $currentLunchTime->format('H:i');
            $currentLunchTime->add($interval);
        }

        while ($currentDinnerTime < $closingDinnerTime) {
            $timeRangeDinner[$currentDinnerTime->format('H:i')] = $currentDinnerTime->format('H:i');
            $currentDinnerTime->add($interval);
        }

        return [
            'lunch' => $timeRangeLunch,
            'dinner' => $timeRangeDinner,
        ];
    }
}