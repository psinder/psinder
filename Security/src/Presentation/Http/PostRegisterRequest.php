<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Presentation\Http;

final class PostRegisterRequest
{
    public string $type;

    public string $email;

    public string $password;

    /** @var mixed[] */
    public array $context;
}
