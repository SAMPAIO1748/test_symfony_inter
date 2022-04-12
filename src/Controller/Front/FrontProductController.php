<?php

namespace App\Controller\Front;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontProductController extends AbstractController
{
    /**
     * @Route("/products/", name="front_product_list")
     */
    public function frontProductList(ProductRepository $productRepository)
    {
        $products = $productRepository->findAll();

        return $this->render('front/product_list.html.twig', ['products' => $products]);
    }

    /**
     * @Route("product/{id}", name="front_product_show")
     */
    public function frontProductShow(ProductRepository $productRepository, $id)
    {
        $product = $productRepository->find($id);

        return $this->render('front/product_show.html.twig', ['product' => $product]);
    }
}
