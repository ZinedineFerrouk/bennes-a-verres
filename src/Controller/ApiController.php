<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\BenneRepository;
use App\Service\Api\ApiService;
use App\Service\Security\ApiTokenAccessService;

/**
 * @Route("/api")
 */
class ApiController extends AbstractController
{
    /**
     * @var ApiTokenAccessService
     */
    private $apiTokenAccessService;

    /**
     * @var ApiService 
     */
    private $apiService;

    /**
     * @var BenneRepository
     */
    private $benneRepository;

    public function __construct(ApiTokenAccessService $apiTokenAccessService, ApiService $apiService, BenneRepository $benneRepository)
    {
        $this->apiTokenAccessService  = $apiTokenAccessService;
        $this->apiService  = $apiService;
        $this->benneRepository  = $benneRepository;
    }

    /**
     * @Route("/benne-a-verre/{token}", name="api_get_benne_a_verre", methods={"GET"})
     */
    public function getBenne(String $token)
    {
        $this->apiTokenAccessService->isValidToken($token, 'api_access_token');   
        $this->apiService->updateApiFromRemote();
        return $this->json($this->benneRepository->findAll(), 200);
    }

    /**
     * @Route("/benne-a-verre/{token}", name="api_post_benne_a_verre", methods={"POST"})
     */
    public function postBenne(String $token, Request $request)
    {
        dd($request->request);
        $user = $this->apiTokenAccessService->isValidToken($token, 'api_access_token');
        $this->apiTokenAccessService->isRoleGranted($user);
        throw new \Exception("Not implement yet");
    }
}
