<?php

namespace App\Controller\Admin;

use App\Entity\Bougie;
use App\Entity\Marque;
use App\Form\BrandType;
use App\Repository\MarqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Doctrine\DBAL\Connection;

class BrandController extends AbstractController
{
    #[Route('/admin/brand', name: 'admin_Brand',methods:["GET","POST"])]
    public function listebrand(MarqueRepository $repo, Request $request): Response
    {
       

        $brand = $repo->findAll();
        return $this->render('admin/brand/listebrands.html.twig', [
            'lesbrands' => $brand
        ]);
    
           
    }

    #[Route('/admin/brand/ajout', name: 'admin_Brand_ajout', methods:["GET","POST"])]
    #[Route('/admin/brand/modif/{id}', name: 'admin_Brand_modif', methods:["GET","POST"])]
    public function ajoutbrand(Marque $brand = null, Request $request, EntityManagerInterface $manager, SluggerInterface $slugger): Response
    {
        if ($brand == null) {
            $brand = new Marque();
            $mode = "ajouté";
        } else {
            $mode = "modifié";
        }
        $form = $this->createForm(BrandType::class, $brand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // handle exception if something happens during file upload
                }

                // updates the 'imageFilename' property to store the image file name
                // instead of its contents
                $brand->setImageFilename($newFilename);
            }

            $manager->persist($brand);
            $manager->flush();
             $this->addFlash("success","La brand a été $mode");
            return$this->redirectToRoute('admin_Brand');
        }
        return $this->render('admin/brand/formAjoutModifbrand.html.twig', [
            'formBrand' => $form->createView()
        ]);
    }
    #[Route('/admin/brand/suppr/{id}', name: 'admin_Brand_suppr', methods: ["GET"])]
    public function supprBrand(Marque $marque, EntityManagerInterface $manager)
    {
            $manager->remove($marque);
            $manager->flush(); 
            $this->addFlash("success","La marque a été supprimée");
            return$this->redirectToRoute('admin_Brand');

    }

    #[Route('/articles/brand', name: 'article_per_brand')]
    public function index(Connection $connection): Response
    {
        $sql = "SELECT * FROM viewMarque";
        $marques = $connection->fetchAllAssociative($sql);
        return $this->render('brand/articlePerBrand.html.twig', [
            'marques' => $marques,
        ]);
    }

}