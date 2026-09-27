<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccountController extends AbstractController
{
    // Placeholder replacing account/orders.php — build out once
    // the merch order flow (MerchOrder) is wired up.
    #[Route('/account/orders', name: 'app_account_orders')]
    public function orders(): Response
    {
        return new Response('Order history not built yet — coming soon.');
    }
}
