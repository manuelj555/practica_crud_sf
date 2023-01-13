<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Exception\ValidationException;
use App\Form\Type\CategoryType;
use App\Repository\CategoryRepository;
use App\Service\Category\UseCase\ChangeCategoryStatusUseCase;
use App\Service\Category\UseCase\CreateCategoryUseCase;
use App\Service\Category\UseCase\EditCategoryUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Exception\ValidationFailedException;

#[Route('/admin/categories', name: 'admin_category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function index(CategoryRepository $repository): Response
    {
        $categories = $repository->findAll();

        return $this->render('admin/category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request, CreateCategoryUseCase $useCase): Response
    {
        $form = $this->createForm(CategoryType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $useCase->handle($form);
            $this->addFlash('success', 'Categoria creada con exito!!!');

            return $this->redirectToRoute('admin_category_list');
        }

        return $this->render('admin/category/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/edit/{id}/', name: 'edit')]
    public function edit(Request $request, Category $category, EditCategoryUseCase $useCase): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $useCase->handle($category);
            $this->addFlash('success', 'Categoria editada con exito!!!');

            return $this->redirectToRoute('admin_category_list');
        }

        return $this->render('admin/category/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/activate/{id}/', name: 'activate')]
    public function activate(Category $category, ChangeCategoryStatusUseCase $useCase): Response
    {
        $useCase->activate($category);
        $this->addFlash('success', 'Categoria activada exitosamente!!!');

        return $this->redirectToRoute('admin_category_list');
    }

    #[Route('/inactivate/{id}/', name: 'inactivate')]
    public function inactivate(Category $category, ChangeCategoryStatusUseCase $useCase): Response
    {
        try {
            $useCase->inactivate($category);
            $this->addFlash('success', 'Categoria inactivada exitosamente!!!');

        } catch (ValidationException $exception) {
            $this->addFlash('error', $exception->getMessage());
        }

        return $this->redirectToRoute('admin_category_list');
    }
}
