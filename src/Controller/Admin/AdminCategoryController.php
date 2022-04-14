<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AdminCategoryController extends AbstractController
{

    public function listCategory(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();

        return $this->render("admin/category_list.html.twig", ['categories' => $categories]);
    }

    public function showCategory($id, CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->find($id);

        return $this->render("admin/category_show.html.twig", ['category' => $category]);
    }

    public function createCategory(Request $request, EntityManagerInterface $entityManagerInterface)
    {
        $category = new Category();

        $categoryForm = $this->createForm(CategoryType::class, $category);

        $categoryForm->handleRequest($request);

        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {
            $entityManagerInterface->persist($category);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_list_category");
        }

        return $this->render("admin/category_form.html.twig", ['categoryForm' => $categoryForm->createView()]);
    }

    public function updateCategory(
        $id,
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        CategoryRepository $categoryRepository
    ) {

        $category = $categoryRepository->find($id);

        $categoryForm = $this->createForm(CategoryType::class, $category);

        $categoryForm->handleRequest($request);

        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {
            $entityManagerInterface->persist($category);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('admin_list_category');
        }

        return $this->render("admin/category_form.html.twig", ['categoryForm' => $categoryForm->createView()]);
    }

    public function deleteCategory(
        $id,
        EntityManagerInterface $entityManagerInterface,
        CategoryRepository $categoryRepository
    ) {
        $category = $categoryRepository->find($id);

        $entityManagerInterface->remove($category);

        $entityManagerInterface->flush();

        return $this->redirectToRoute("admin_list_category");
    }
}
