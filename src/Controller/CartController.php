<?php

namespace App\Controller;

use App\Entity\Bougie;
use App\Entity\Poudre;
use App\Form\CartType;
use App\Entity\Produit;
use App\Manager\CartManager;
use App\Entity\ObjetDecoration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class CartController
 * @package App\Controller
 */
class CartController extends AbstractController
{
    #[Route('/cart', name: 'view_cart', methods: ['GET'])]
    public function index(CartManager $cartManager, Request $request): Response
    {
        $cart = $cartManager->getCurrentCart();

        return $this->render('cart/cart.html.twig', [
            'cart' => $cart,
        ]);
    }

    #[Route('/add-to-cart/{type}/{id}', name: 'add_to_cart', methods: ['POST'])]
    public function addToCart(string $type, int $id, Request $request, CartManager $cartManager, EntityManagerInterface $entityManager): Response
    {
        // Determine the entity class based on the type
        $entityClass = $this->getEntityClass($type);

        if (!$entityClass) {
            throw $this->createNotFoundException('Invalid product type');
        }

        // Fetch the product using the entity manager
        $produit = $entityManager->getRepository($entityClass)->find($id);

        if (!$produit) {
            throw $this->createNotFoundException('Product not found');
        }

        $cart = $cartManager->getCurrentCart();
        $cartManager->addProductToCart($cart, $produit);

        $this->addFlash('success', 'Le produit a bien été ajouté au panier!');

        return $this->redirect($request->headers->get('referer'));
    }

    private function getEntityClass(string $type): ?string
    {
        return match ($type) {
            'bougie' => Bougie::class,
            'objet_decoration' => ObjetDecoration::class,
            'poudre' => Poudre::class,
            default => null,
        };
    }
}