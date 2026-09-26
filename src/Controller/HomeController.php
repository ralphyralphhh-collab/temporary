<?php

namespace App\Controller;

use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    // Replaces index.php. The `SELECT ... WHERE is_published = 1
    // ORDER BY created_at DESC LIMIT 2` query becomes a repository method.
    #[Route('/', name: 'app_home')]
    public function index(ReviewRepository $reviews): Response
    {
        return $this->render('home/index.html.twig', [
            'published_reviews' => $reviews->findPublishedLatest(2),
        ]);
    }
}
