<?php

namespace App\Controller\Admin;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminHomeController extends AbstractController
{
    public function adminSearch(Request $request, CategoryRepository $categoryRepository)
    {
        $term = $request->query->get('term');

        $categories = $categoryRepository->searchByTerm($term);

        return $this->render("admin/search.html.twig", ['categories' => $categories, 'term' => $term]);
    }
}
