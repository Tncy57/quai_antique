<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Entity\Schedule;
use App\Entity\Menu;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $photoRepository = $entityManager->getRepository(Photo::class);
        $photo = $photoRepository->find(4);

        $scheduleRepository = $entityManager->getRepository(Schedule::class);
        $schedules = $scheduleRepository->findAll();

        $menuRepository = $entityManager->getRepository(Menu::class);
        $menus = $menuRepository->findAll();

        return $this->render('home/index.html.twig', [
            'photo' => $photo,
            'schedules' => $schedules,
            'menus' => $menus,
        ]);
    }
}
