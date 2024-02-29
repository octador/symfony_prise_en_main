<?php

namespace App\Controller;

use App\Repository\CampaignRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CampaignRepository $campagnRepository): Response
    {
        $campaigns = $campagnRepository->findAll();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'campaigns'=> $campaigns
        ]);

   }
        #[Route('/creat', name: 'app_creat')]
        public function creat(): Response
    {
        return $this->render('home/creat.html.twig', [
            
        ]);
    }
    
}
