<?php

namespace App\Controller;

use App\Repository\MerchStockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MerchController extends AbstractController
{
    #[Route('/merch', name: 'app_merch')]
    public function index(MerchStockRepository $merchStock): Response
    {
        return $this->render('merch/index.html.twig', [
            'prices' => $merchStock->findAllPrices(),
        ]);
    }

    // Placeholder so links from merch/index.html.twig don't 404 —
    // the real order form (replacing actions/order.php) is a later step.
    #[Route('/order', name: 'app_order')]
    public function order(): Response
    {
        return new Response('Order flow not built yet — coming soon.');
    }
}
