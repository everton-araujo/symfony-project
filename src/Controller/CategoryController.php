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
}
