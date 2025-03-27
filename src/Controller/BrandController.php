<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Repository\MarqueRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BrandController extends AbstractController
{
    #[Route('/brands', name: 'brands')]
    public function listebrands(Request $request, MarqueRepository $MarqueRepository ): Response
    {
    
        $brands = $MarqueRepository->findAll();
        

        return $this->render('brand/listebrands.html.twig', [
            
            'Lesbrands' => $brands,
        ]);
    }
}
