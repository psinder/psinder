<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Presentation\Http;

final class PostRegisterRequest
{
    public string $id;
    /** @var string[] */
    public array $roles;
    public string $email;
    public string $password;
}
