<?php

namespace App\Controller;

use App\Entity\Schedule;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\TestFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
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
        $form = $this->createForm(TestFormType::class, null, [
            'timeRangeLunch' => $timeRanges['lunch'],
            'timeRangeDinner' => $timeRanges['dinner'],
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Form submitted and valid, handle the data here
            $data = $form->getData();
            // ...
        }

        return $this->render('test/index.html.twig', [
            'form' => $form->createView(),
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

