<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/categoria', name: 'category_index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        // Buscar no DB todas categorias cadastradas
        $data['categories'] = $categoryRepository->findAll();
        $data['title'] = 'Gerenciar Categorias';

        return $this->render('category/index.html.twig', $data);
    }

    #[Route('/categoria/adicionar', name: 'category_add')]
    public function addCategory(Request $request, EntityManagerInterface $entityManager): Response
    {
        $message = '';
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Salvar nova categoria no DB
            $entityManager->persist($category); // Salva na memória
            $entityManager->flush();
            $message = 'Categoria adicionada';
        }
        
        $data['title'] = 'Adicionar nova categoria';
        $data['form'] = $form;
        $data['message'] = $message;

        return $this->render('category/form.html.twig', $data);
    }

    #[Route('/categoria/editar/{id}', name: 'category_edit')]
    public function edit($id, Request $request, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): Response
    {
        $message = '';
        $category = $categoryRepository->find($id); // Retorna categoria pelo id

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush(); // Fazer update na categoria no DB
            $message = 'Categoria atualizada';
        }

        $data['title'] = 'Editar categoria';
        $data['form'] = $form;
        $data['message'] = $message;

        return $this->render('category/form.html.twig', $data);
    }

    #[Route('/categoria/excluir/{id}', name: 'category_delete')]
    public function delete($id, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->find($id);
        $entityManager->remove($category); // Exclui a categoria a nível de memória
        $entityManager->flush(); // Efetivamente exclui do DB

        // Redirecionar a aplicação para a categoria_index
        return $this->redirectToRoute('category_index');
    }
}
