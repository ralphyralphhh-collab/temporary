<?php

namespace App\Controller;

use App\Entity\ContactMessage;
use App\Form\ContactFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PagesController extends AbstractController
{
    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('about/index.html.twig');
    }

    #[Route('/rent', name: 'app_rent')]
    public function rent(): Response
    {
        return $this->render('rent/index.html.twig');
    }

    // Replaces contacts.php + actions/contact.php
    #[Route('/contacts', name: 'app_contacts')]
    public function contacts(Request $request, EntityManagerInterface $em): Response
    {
        $contactMessage = new ContactMessage();
        $form = $this->createForm(ContactFormType::class, $contactMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($contactMessage);
            $em->flush();

            $this->addFlash('success', "Thanks for reaching out! We'll get back to you soon.");

            return $this->redirectToRoute('app_contacts');
        }

        return $this->render('contacts/index.html.twig', ['form' => $form]);
    }
}
