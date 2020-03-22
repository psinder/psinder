<?php

declare(strict_types = 1);

namespace Sip\Psinder\E2E\Collection;

use Lcobucci\JWT\Token;

interface Tokens
{
    public function current() : Token;
    public function get( string $id ): ?Token;
    public function obtain( string $email, string $password ): ?Token;
}