<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/produto', name: 'product_index')]
    #[IsGranted('ROLE_USER')]
    public function index(ProductRepository $productRepository)
    {
        // Busca os produtos cadastrados
        $data['products'] = $productRepository->findAll();
        $data['title'] = 'Gerenciar Produtos';

        return $this->render('product/index.html.twig', $data);
    }

    #[Route('/produto/adicionar', name: 'product_add')]
    #[IsGranted('ROLE_USER')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $message = '';
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Salva o produto no DB
            $entityManager->persist($product);
            $entityManager->flush();
            $message = 'Produto cadastrado';
        }

        $data['title'] = 'Adicionar novo produto';
        $data['form'] = $form;
        $data['message'] = $message;

        return $this->render('product/form.html.twig', $data);
    }

    #[Route('/produto/editar/{id}', name: 'product_edit')]
    #[IsGranted('ROLE_USER')]
    public function edit($id, Request $request, EntityManagerInterface $entityManager, ProductRepository $productRepository): Response
    {
        $message = '';
        $product = $productRepository->find($id);

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $message = 'Produto atualizado';
        }

        $data['title'] = 'Editar produto';
        $data['form'] = $form;
        $data['message'] = $message;

        return $this->render('product/form.html.twig', $data);
    }

    #[Route('/produto/excluir/{id}', name: 'product_delete')]
    #[IsGranted('ROLE_USER')]
    public function delete($id, EntityManagerInterface $entityManager, ProductRepository $productRepository): Response
    {
        $product = $productRepository->find($id);

        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute('product_index');
    }
}
