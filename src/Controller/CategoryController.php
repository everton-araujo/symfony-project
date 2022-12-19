<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/categoria', name: 'category_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // $entityManager -> objeto que auxilia a execução de ações no BD
        $category = new Category();
        $category->setDescription('Informática');

        try {
            $entityManager->persist($category); // Salva a persistência em nível de memória
            $entityManager->flush(); // executa em definitivo no BD

            $message = 'Categoria salva com sucesso';
        } catch(Exception $error) {
            $message = 'Erro ao cadastrar categoria' . $error;
        }

        return new Response('<h1>' . $message . '</h1>');
    }

    #[Route('/categoria/adicionar', name: 'category_add')]
    public function add(): Response
    {
        $form = $this->createForm(CategoryType::class);
        
        $data['title'] = 'Adicionar nova categoria';
        $data['form'] = $form;

        return $this->render('category/form.html.twig', $data);
    }
}
