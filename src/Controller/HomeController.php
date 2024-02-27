<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);

   }
        #[Route('/creat', name: 'app_creat')]
        public function creat(): Response
    {
        return $this->render('home/creat.html.twig', [
            
        ]);
    }
    #[Route('/array', name: 'app_array')]
        public function array(): Response
    {$arrays = [1,2,3,4,5];

        return $this->render('home/array.html.twig', [
            'arrays'=> $arrays
            
        ]);
    }

 
}
