<?php

namespace App\Controller;

use App\Entity\Registration;
use App\Form\RegistrationFormType;
use App\Repository\RegistrationRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class JoinController extends AbstractController
{
    // Replaces join.php + actions/register.php in one action.
    // CSRF is handled automatically by the form (no includes/csrf.php).
    #[Route('/join', name: 'app_join')]
    public function join(Request $request, EntityManagerInterface $em): Response
    {
        $registration = new Registration();
        $form = $this->createForm(RegistrationFormType::class, $registration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->persist($registration);
                $em->flush();
            } catch (UniqueConstraintViolationException) {
                // Mirrors the 1062/23000 duplicate-email check in register.php
                $form->get('email')->addError(
                    new \Symfony\Component\Form\FormError('This email is already registered.')
                );

                return $this->renderJoinResponse($request, $form);
            }

            if ($request->isXmlHttpRequest()) {
                return new JsonResponse([
                    'success' => true,
                    'message' => "Thanks for registering! We'll be in touch soon.",
                ]);
            }

            $this->addFlash('success', "Thanks for registering! We'll be in touch soon.");

            return $this->redirectToRoute('app_join');
        }

        return $this->renderJoinResponse($request, $form);
    }

    private function renderJoinResponse(Request $request, $form): Response
    {
        if ($request->isXmlHttpRequest() && $form->isSubmitted()) {
            $errors = [];
            foreach ($form->all() as $name => $child) {
                foreach ($child->getErrors() as $error) {
                    $errors[$name] = $error->getMessage();
                }
            }

            return new JsonResponse([
                'success' => false,
                'errors'  => $errors,
                'message' => 'Please fix the highlighted fields.',
            ], 422);
        }

        return $this->render('join/index.html.twig', ['form' => $form]);
    }
}
