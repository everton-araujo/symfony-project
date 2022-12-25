<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/api/products', name: 'api_products')]
    public function index(ProductRepository $productRepository): Response
    {
        $productList = $productRepository->findAll();

        return $this->json($productList, 200, [], ['groups' => ['api_list']]);
    }
}
