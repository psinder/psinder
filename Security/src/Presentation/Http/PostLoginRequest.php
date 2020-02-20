<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Presentation\Http;

final class PostLoginRequest
{
    /** @var string */
    public $username;

    /** @var string */
    public $password;
}
