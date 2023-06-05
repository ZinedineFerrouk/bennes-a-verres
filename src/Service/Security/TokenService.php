<?php

namespace App\Service\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Exception;

class TokenService extends AbstractTokenService 
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
     * Check if user token exist
     * @param String $token 
     * @return void 
     * @throws Exception 
     */
    public function isValidToken(String $token, String $column)
    {
        if ($column != self::USER_TOKEN_COLUMN) {
            throw new \Exception("Error Bad Database Request");
        }
        $user = $this->userRepository->findOneBy([$column => $token]);
        if (!$user) {
            throw new \Exception("Error the token does not exist");
        }
    }
}
