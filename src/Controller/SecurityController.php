<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    // Replaces login.php
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Symfony's form_login handles CSRF, password checking and the
        // ?redirect= target automatically — no need for includes/csrf.php
        // or the manual $_SESSION['user_id'] checks from customer_auth.php.
        return $this->render('security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error'         => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    // Replaces logout.php — Symfony intercepts this route via the
    // firewall's `logout:` config, so this method body never runs.
    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('Intercepted by the logout key on your firewall.');
    }
}
