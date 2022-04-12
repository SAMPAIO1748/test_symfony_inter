<?php

namespace App\Controller\Front;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontHomeController extends AbstractController
{
    /**
     * @Route("search/", name="front_search")
     */
    public function search(ProductRepository $productRepository, Request $request)
    {
        // Récupérer les informations du formulaire
        $term = $request->query->get('term');
        // query sert au formulaire en get, pour les formulaires post il faut utiliser request

        $products = $productRepository->searchByTerm($term);

        return $this->render("front/search.html.twig", ['products' => $products, 'term' => $term]);
    }
}
