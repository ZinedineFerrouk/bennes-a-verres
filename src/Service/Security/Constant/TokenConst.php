<?php

namespace App\Service\Security\Constant;

/**
 * Const for tokens
 */
abstract class TokenConst
{

    const CIPHER = 'AES-256-CFB';
    const KEY = 'UrPvYw3y8Q8DaFcJfMhYsSpUsXuZw4';
    const IV = 'eKhPkRnUrWtYw3y5';
    const API_ACCESS_TOKEN_COLUMN = 'api_access_token';
    const USER_TOKEN_COLUMN = 'user_token';

}
