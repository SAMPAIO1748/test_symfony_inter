<?php

namespace App\Controller\Admin;

use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCategoryController extends AbstractController
{
    /**
     * @Route("admin/categories", name="admin_list_category")
     */
    public function listCategory(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();

        return $this->render("admin/category_list.html.twig", ['categories' => $categories]);
    }

    /**
     * @Route("admin/category/{id}", name="admin_show_category")
     */
    public function showCategory($id, CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->find($id);

        return $this->render("admin/category_show.html.twig", ['category' => $category]);
    }
}
