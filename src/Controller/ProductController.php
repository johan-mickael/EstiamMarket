<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\Type\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/products')]
class ProductController extends AbstractController
{

	#[Route('/', name: 'product_list')]
	public function index(ManagerRegistry $doctrine): Response
	{
		$products = $doctrine->getRepository(Product::class)->findAll();
		return $this->render('product/index.html.twig', compact('products'));
	}

	#[Route('/new', name: 'product_new', methods: ['GET', 'POST'])]
	public function new(Request $request, EntityManagerInterface $entityManager): Response
	{
		$product = new Product();
		$form = $this->createForm(ProductType::class, $product);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager->persist($form->getData());
			$entityManager->flush();
			return $this->redirectToRoute('product_list');
		}
		return $this->renderForm('product/new.html.twig', compact('form'));
	}


	#[Route('/{id}', name: 'product_show', methods: ['GET'], requirements: ["id" => "\d+"])]
	public function show(Product $product)
	{
		return $this->render('product/show.html.twig', compact('product'));
	}

	#[Route('/{id}/edit', name: 'product_edit', methods: ['GET', 'POST'])]
	public function edit(Request $request, EntityManagerInterface $entityManager, Product $product): Response
	{
		$form = $this->createForm(ProductType::class, $product);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager->flush();
			return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
		}
		return $this->renderForm('product/edit.html.twig', compact('product', 'form'));
	}

	#[Route('/{id}', name: 'product_delete', methods: ['POST'])]
	public function delete(Request $request, EntityManagerInterface $entityManager, Product $product): Response
	{
		if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token'))) {
			$entityManager->remove($product);
			$entityManager->flush();
		}

		return $this->redirectToRoute('product_list', [], Response::HTTP_SEE_OTHER);
	}
}
