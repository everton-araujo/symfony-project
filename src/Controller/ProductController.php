<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/produto', name: 'product_index')]
    public function index(EntityManagerInterface $entityManager, CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->find(1); // 1 = Categoria informática

        $product = new Product();
        $product->setName('Notebook');
        $product->setPrice(4500);
        $product->setCategory($category);

        try {
            $entityManager->persist($product);
            $entityManager->flush();

            $message = 'Produto ' . $product->getName() .' cadastrado com sucesso';
        } catch (Exception $error) {
            $message = 'Erro ao cadastrar produto' . $error;
        }

        return new Response('<h1>' . $message . '</h1>');
    }

    #[Route('/produto/adicionar', name: 'product_add')]
    public function add(): Response
    {
        $form = $this->createForm(ProductType::class);

        $data['title'] = 'Adicionar novo produto';
        $data['form'] = $form;

        return $this->render('product/form.html.twig', $data);
    }
}
