<?php

namespace App\Service\Security;

use App\Service\Security\Constant\TokenConst;

/**
 * Abstract class for token service
 */
abstract class AbstractTokenService extends TokenConst
{
    /**
     * Generate token with data from user
     * @param array $data 
     * @return String 
     */
    public function generateToken(array $data): String
    {
        return base64_encode(openssl_encrypt(serialize($data), self::CIPHER, self::KEY, 0, self::IV));
    }

    /**
     * Decypte token
     * @param String $token 
     * @return array 
     */
    public function decryptToken(string $token): array
    {
        return unserialize(openssl_decrypt(base64_decode($token), self::CIPHER, self::KEY, 0, self::IV));
    }

    /**
     * @param String $token 
     * @return void 
     * @throws Exception 
     */
    public function isValidToken(String $token, String $column) {}
}
