<?php

namespace App\Controller;

use App\Entity\Bougie;
use App\Repository\BougieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BougieController extends AbstractController
{
    #[Route('/bougie', name: 'app_bougie', methods: 'GET')]
    public function listeBougie(BougieRepository $repo): Response
    {
        $bougies=$repo->findAll();
        return $this->render('bougie/listeBougies.html.twig', [
            'LesBougies' => $bougies
        ]);
    }
}
