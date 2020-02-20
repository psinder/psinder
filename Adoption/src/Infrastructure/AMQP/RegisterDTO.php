<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Infrastructure\AMQP;

final class RegisterDTO
{
    /** @var string */
    public $id;
    /** @var string */
    public $email;
    /** @var mixed[] */
    public $context;
    /** @var string[] */
    public $roles;
}
