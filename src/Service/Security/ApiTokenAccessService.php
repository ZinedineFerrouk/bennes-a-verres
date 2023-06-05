<?php

namespace App\Service\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\Security\AbstractTokenService;
use Exception;

class ApiTokenAccessService extends AbstractTokenService 
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Check if api access token exist
     * @param String $token 
     * @return User 
     * @throws Exception 
     */
    public function isValidToken(String $token, String $column)
    {
        if ($column != self::API_ACCESS_TOKEN_COLUMN) {
            throw new \Exception("Error Bad Database Request");
        }
        $user = $this->userRepository->findOneBy([$column => $token]);
        if (!$user) {
            throw new \Exception("Error the token does not exist");
        }
        return $user;
    }

    /**
     * Check if user can post new benne
     * @param User $user 
     * @return void 
     * @throws Exception 
     */
    public function isRoleGranted(User $user) 
    {
        $role = $user->getRoles();
        if (!in_array('ROLE_ADMIN', $role)) {
            throw new \Exception("Error You Cant Post New Benne");
        }
    }
}
