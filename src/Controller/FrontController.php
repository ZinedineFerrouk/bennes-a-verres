<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Service\Security\TokenService;
use App\Service\Email\EmailService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\Security\ApiTokenAccessService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class FrontController extends AbstractController
{
    private $mailer;

    public function __construct(EmailService $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @Route("/", name="home")
     */
    public function home(TokenService $tokenService, ApiTokenAccessService $apiTokenAccessService, Request $request): Response
    {
        $form = $this->createForm(ContactType::class);

        // Récupération des données du contact form + envoi de mail
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $this->mailer->sendContactEmail($data);
            $this->addFlash('success', 'Votre message a bien été envoyé.');
        }

        // dd($apiTokenAccessService->generateApiAccessToken());
        return $this->render('front/home.html.twig', [
            'contactForm' => $form->createView()
        ]);
    }
}