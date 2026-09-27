<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerRegisterFormType;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class CustomerAccountController extends AbstractController
{
    // Replaces account/register.php
    #[Route('/account/register', name: 'app_customer_register')]
    public function register(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $hasher,
    ): Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_account_orders');
        }

        $customer = new Customer();
        $form = $this->createForm(CustomerRegisterFormType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $customer->setPassword(
                $hasher->hashPassword($customer, $form->get('plainPassword')->getData())
            );

            try {
                $em->persist($customer);
                $em->flush();
            } catch (UniqueConstraintViolationException) {
                // Matches the 23000/1062 duplicate-email check in account/register.php
                $form->get('email')->addError(
                    new \Symfony\Component\Form\FormError('An account with this email already exists.')
                );

                return $this->render('account/register.html.twig', ['form' => $form]);
            }

            $this->addFlash('success', 'Account created! You can now log in.');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('account/register.html.twig', ['form' => $form]);
    }
}
