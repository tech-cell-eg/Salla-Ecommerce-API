<?php

namespace App\DTOs\Auth;

class TokenDTO
{
    public function __construct(
        public string $token,
        public string $type = 'Bearer'
    ) {}
}