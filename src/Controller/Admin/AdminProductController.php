<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AdminProductController extends AbstractController
{
    public function adminProductList(ProductRepository $productRepository)
    {
        $products = $productRepository->findAll();

        return $this->render('admin/product_list.html.twig', ['products' => $products]);
    }

    public function adminProductShow($id, ProductRepository $productRepository)
    {
        $product = $productRepository->find($id);

        return $this->render('admin/product_show.html.twig', ['product' => $product]);
    }

    public function adminCreateProduct(Request $request, EntityManagerInterface $entityManagerInterface)
    {
        $product = new Product();

        $productForm = $this->createForm(ProductType::class, $product);

        $productForm->handleRequest($request);

        if ($productForm->isSubmitted() && $productForm->isValid()) {
            $entityManagerInterface->persist($product);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_product_list");
        }

        return $this->render("admin/product_form.html.twig", ['productForm' => $productForm->createView()]);
    }

    public function adminProductUpdate(
        $id,
        EntityManagerInterface $entityManagerInterface,
        Request $request,
        ProductRepository $productRepository
    ) {
        $product = $productRepository->find($id);

        $productForm = $this->createForm(ProductType::class, $product);

        $productForm->handleRequest($request);

        if ($productForm->isSubmitted() && $productForm->isValid()) {
            $entityManagerInterface->persist($product);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_product_list");
        }

        return $this->render("admin/product_form.html.twig", ['productForm' => $productForm->createView()]);
    }

    public function adminDeleteProduct($id, EntityManagerInterface $entityManagerInterface, ProductRepository $productRepository)
    {
        $product = $productRepository->find($id);

        $entityManagerInterface->remove($product);
        $entityManagerInterface->flush();

        return $this->redirectToRoute('admin_product_list');
    }
}
