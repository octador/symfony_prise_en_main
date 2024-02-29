<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Entity\Payment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PaymentController extends AbstractController
{
    #[Route('/{id}/payment', name: 'app_payment')]
    public function new(Campaign $campaign): Response
    {   
       $payment =new Payment;

        return $this->render('campaign/payment.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }
}
