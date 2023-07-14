<?php

namespace App\Controller;

use App\Repository\DishRepository;
use App\Entity\Photo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DishController extends AbstractController
{
    #[Route('/dishes', name: 'app_dish')]
    public function index(DishRepository $dishRepository, EntityManagerInterface $entityManager): Response
    {
        $dishes = $dishRepository->findAll();

        $photoRepository = $entityManager->getRepository(Photo::class);
        $photo = $photoRepository->find(2);

        return $this->render('dish/index.html.twig', [
            'dishes' => $dishes,
            'photo' => $photo,
        ]);
    }
}
