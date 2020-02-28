<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Presentation\Http;

final class PostLoginRequest
{
    /** @var string */
    public $email;

    /** @var string */
    public $password;
}
