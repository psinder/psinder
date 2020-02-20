<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Application\UseCase;

final class RegisterUserDTO
{
    /** @var string */
    private $id;

    /** @var string */
    private $type;

    /** @var mixed[] */
    private $context;

    /** @var string */
    private $email;

    /** @var string */
    private $password;

    /**
     * @param mixed[] $context
     */
    public function __construct(string $id, string $type, string $email, string $password, array $context)
    {
        $this->id       = $id;
        $this->type     = $type;
        $this->context  = $context;
        $this->email    = $email;
        $this->password = $password;
    }

    public function id() : string
    {
        return $this->id;
    }

    public function type() : string
    {
        return $this->type;
    }

    /**
     * @return mixed[]
     */
    public function context() : array
    {
        return $this->context;
    }

    public function email() : string
    {
        return $this->email;
    }

    public function password() : string
    {
        return $this->password;
    }
}
