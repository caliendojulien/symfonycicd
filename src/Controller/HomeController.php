<?php

namespace App\Controller;

use App\Entity\Proprietaire;
use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\ProprietaireRepository;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(VoitureRepository $voitureRepository, SerializerInterface $serializer): Response
    {
        $voitures = $voitureRepository->findAll();
        return new Response($serializer->serialize($voitures, 'json', ['groups' => ['voitures']]));
    }

    #[Route('/', name: 'app_home2')]
    public function home(
        Request                $request,
        EntityManagerInterface $entityManager,
        ProprietaireRepository $proprietaireRepository
    ): Response
    {
        $voiture = new Voiture();
        $voitureForm = $this->createForm(VoitureType::class, $voiture);

        $voitureForm->handleRequest($request);

        if ($voitureForm->isSubmitted() && $voitureForm->isValid()) {
            $entityManager->persist($voiture);
            $entityManager->flush();
        }
        return $this->render(
            'home/index.html.twig',
            compact('voitureForm')
        );
    }
}
