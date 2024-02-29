<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Entity\Participant;
use App\Form\CampaignType;
use App\Form\ParticipantType;
use App\Repository\CampaignRepository;
use App\Repository\ParticipantRepository;
use ContainerKxVltxT\getParticipantService;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/campaign')]
class CampaignController extends AbstractController
{
    #[Route('/', name: 'app_campaign_index', methods: ['GET'])]
    public function index(CampaignRepository $campaignRepository): Response
    {
        return $this->render('campaign/index.html.twig', [
            'campaigns' => $campaignRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_campaign_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $campaign = new Campaign();
        $participant = new Participant();

        $form = $this->createForm(CampaignType::class, $campaign);
       

        $form->handleRequest($request);

            // dd($campaign);
        if ($form->isSubmitted() && $form->isValid()) {
            // hydratation
          $participant = $form->get('participant')->getData();
          $campaign->setName($participant->getName());
          
        //   dd($participant);
            $campaign->setCreatedAt(new DateTimeImmutable());
            $campaign->setUpdatedAt(new DateTimeImmutable());
            
            $campaign->addParticipant($participant);
            $participant->addCampaign($campaign);

            $entityManager->persist($campaign);
            $entityManager->persist($participant);

            $entityManager->flush();

            return $this->redirectToRoute('app_campaign_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('campaign/new.html.twig', [
            'campaign' => $campaign,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_campaign_show', methods: ['GET'])]
    public function show(Campaign $campaign, ParticipantRepository $participantRepository): Response
    {
        // $participants = $participantRepository->findBy(['campaign'=>$campaign->getId()]);
        // dd($campaign->getParticipants());
        $participants = $campaign->getParticipants();
// dd($participants);
        return $this->render('campaign/show.html.twig', [
            'participants'=> $participants,
            'campaign' => $campaign,
        ]);
        
        
    }

    #[Route('/{id}/edit', name: 'app_campaign_edit', methods: ['GET', 'POST'])]

    public function edit(Request $request, Campaign $campaign, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CampaignType::class, $campaign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $campaign->setUpdatedAt(new DateTimeImmutable());
            $entityManager->flush();

            return $this->redirectToRoute('app_campaign_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('campaign/edit.html.twig', [
            'campaign' => $campaign,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_campaign_delete', methods: ['POST'])]
    public function delete(Request $request, Campaign $campaign, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$campaign->getId(), $request->request->get('_token'))) {
            $entityManager->remove($campaign);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_campaign_index', [], Response::HTTP_SEE_OTHER);
    }
}
