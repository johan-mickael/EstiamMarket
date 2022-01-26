<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/users')]
class UserController extends AbstractController
{
    #[Route('/', name: 'user_list')]
    public function index(ManagerRegistry $doctrine): Response
	{
		$users = $doctrine->getRepository(User::class)->findAll();
		return $this->render('user/index.html.twig', compact('users'));
	}

	#[Route('/{id}', name: 'user_show', methods:['GET'])]
	public function show(User $user)
	{
		return $this->render('user/show.html.twig', compact('user'));
	}

	#[Route('/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
	public function edit(Request $request, EntityManagerInterface $entityManager, User $user): Response
	{
		$form = $this->createForm(UserType::class, $user);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager->flush();
            return $this->redirectToRoute('user_show', ['id' => $user->getid()]);
        }
        return $this->renderForm('user/edit.html.twig', compact('form', 'user'));
	}

	#[Route('/{id}', name: 'user_delete', methods: ['POST'])]
	public function delete(Request $request, EntityManagerInterface $entityManager, User $user): Response
	{
		if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
			$entityManager->remove($user);
			$entityManager->flush();
		}
		return $this->redirectToRoute('user_list', [], Response::HTTP_SEE_OTHER);
	}
}