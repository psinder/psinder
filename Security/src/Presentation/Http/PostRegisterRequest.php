<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Presentation\Http;

final class PostRegisterRequest
{
    /** @var string */
    public $type;

    /** @var string */
    public $email;

    /** @var string */
    public $password;

    /** @var mixed[] */
    public $context;
}
