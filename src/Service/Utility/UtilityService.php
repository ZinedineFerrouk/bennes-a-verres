<?php

namespace App\Service\Utility;

class UtilityService
{
    /**
     * Generate a random string
     * @var int $length
     * @return String
     */
    public function randomStringGenerator(int $length): String
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        $randomString = '';
        for ($k = 0; $k < $length; $k++) { 
           $randomString .= $chars[ rand( 0, strlen($chars) - 1 ) ];
        }
        return $randomString;
    }
}
