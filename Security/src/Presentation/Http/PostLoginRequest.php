<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Presentation\Http;

final class PostLoginRequest
{
    public string $email;

    public string $password;
}
