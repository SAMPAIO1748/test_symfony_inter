<?php

namespace App\Controller\Front;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontCategoryController extends AbstractController
{
    /**
     * @Route("categories", name="list_category")
     */
    public function listCategory(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();

        return $this->render("front/category_list.html.twig", ['categories' => $categories]);
    }

    /**
     * @Route("category/{id}", name="show_category")
     */
    public function showCategory($id, CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->find($id);

        return $this->render("front/category_show.html.twig", ['category' => $category]);
    }
}
