<?php

namespace App\Controller;

use App\Service\Security\TokenService;
use Symfony\Component\HttpFoundation\Response;
use App\Service\Security\ApiTokenAccessService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{
    /**
     * @Route("/mon-compte", name="my-account")
     */
    public function my_account(TokenService $tokenService, ApiTokenAccessService $apiTokenAccessService): Response
    {
        // dd($apiTokenAccessService->generateApiAccessToken());
        return $this->render('front/profile.html.twig', []);
    }
}
