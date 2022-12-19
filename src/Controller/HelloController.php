<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController 
{
    #[Route('/hello', name: 'hello')]
    public function index(): Response
    {
        $data['title'] = 'Página de teste';
        $data['message'] = 'agora a coisa ta ficando legal';
        $data['fruits'] = [
            [
                'name' => 'banana',
                'price' => 1.99
            ],
            [
                'name' => 'laranja',
                'price' => 2.99
            ],
            [
                'name' => 'limão',
                'price' => 0.99
            ],
        ];

        return $this->render('hello.html.twig', $data);
    }

    #[Route('/hello/detalhes/{id}', name: 'details')]
    public function details($id): Response
    {
        $data['title'] = 'Página de detalhes';
        $data['id'] = $id;

        return $this->render('detalhes.html.twig', $data);
    }
}
