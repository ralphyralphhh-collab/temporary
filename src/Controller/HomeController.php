<?php

namespace App\Controller;

use App\Entity\Review;
use App\Form\ReviewFormType;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    // Replaces index.php
    #[Route('/', name: 'app_home')]
    public function index(ReviewRepository $reviews, Request $request, EntityManagerInterface $em): Response
    {
        $review = new Review();
        $reviewForm = $this->createForm(ReviewFormType::class, $review);
        $reviewForm->handleRequest($request);

        if ($reviewForm->isSubmitted() && $reviewForm->isValid()) {
            // Matches the original: new reviews aren't published until
            // an admin approves them (is_published defaults to false).
            $em->persist($review);
            $em->flush();

            $this->addFlash('success', 'Thanks for your review! It will appear once approved.');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('home/index.html.twig', [
            'published_reviews' => $reviews->findPublishedLatest(2),
            'review_form' => $reviewForm,
        ]);
    }
}
