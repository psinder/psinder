<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Infrastructure\AMQP;

final class RegisterDTO
{
    public string $id;
    public string $email;
    /** @var mixed[] */
    public array $context;
    /** @var string[] */
    public array $roles;
}
