<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\Type\CategoryType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('categories')]
class CategoryController extends AbstractController
{

	#[Route('/', name: 'category_list')]
	public function get(ManagerRegistry $doctrine): Response
	{
		$categories = $doctrine->getRepository(Category::class)->findAll();
		return $this->render('category/index.html.twig', compact('categories'));
	}

	#[Route('/new', name: 'category_new', methods: ['GET', 'POST'])]
	public function new(Request $request, EntityManagerInterface $entityManager): Response
	{
		$category = new Category();
		$form = $this->createForm(CategoryType::class, $category);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager->persist($form->getData());
			$entityManager->flush();
			return $this->redirectToRoute('category_list');
		}
		return $this->renderForm('category/new.html.twig', compact('form'));
	}

	#[Route('/{id}', name: 'category_show', methods:['GET'])]
	public function show(Category $category)
	{
		return $this->render('category/show.html.twig', compact('category'));
	}

	#[Route('/{id}/edit', name: 'category_edit', methods: ['GET', 'POST'])]
	public function edit(Request $request, EntityManagerInterface $entityManager, Category $category): Response
	{
		$form = $this->createForm(CategoryType::class, $category);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager->flush();
            return $this->redirectToRoute('category_list');
        }

        return $this->renderForm('category/edit.html.twig', [
            'employee_category' => $category,
            'form' => $form,
        ]);
	}

	#[Route('/{id}', name: 'category_delete', methods: ['POST'])]
	public function delete(Request $request, EntityManagerInterface $entityManager, Category $category): Response
	{
		if ($this->isCsrfTokenValid('delete' . $category->getId(), $request->request->get('_token'))) {
			$entityManager->remove($category);
			$entityManager->flush();
		}

		return $this->redirectToRoute('category_list', [], Response::HTTP_SEE_OTHER);
	}

}
