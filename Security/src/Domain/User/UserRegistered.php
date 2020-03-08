<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Domain\User;

use DateTimeImmutable;
use Sip\Psinder\SharedKernel\Domain\Email;
use Sip\Psinder\SharedKernel\Domain\Event;
use Sip\Psinder\SharedKernel\Domain\PayloadableEvent;

final class UserRegistered implements Event, PayloadableEvent
{
    private string $id;

    /** @var mixed[] */
    private array $context;

    /** @var string[] */
    private array $roles;

    private DateTimeImmutable $occurredAt;

    private string $email;

    /**
     * @param mixed[]  $context
     * @param string[] $roles
     */
    private function __construct(string $id, string $email, array $roles, array $context, DateTimeImmutable $occurredAt)
    {
        $this->id         = $id;
        $this->context    = $context;
        $this->roles      = $roles;
        $this->occurredAt = $occurredAt;
        $this->email      = $email;
    }

    /**
     * @param mixed[] $context
     */
    public static function occur(UserId $id, Email $email, Roles $roles, array $context) : self
    {
        return new self(
            $id->toScalar(),
            $email->toString(),
            $roles->toScalarArray(),
            $context,
            new DateTimeImmutable()
        );
    }

    public function id() : string
    {
        return $this->id;
    }

    public function email() : string
    {
        return $this->email;
    }

    /** @return string[] */
    public function roles() : array
    {
        return $this->roles;
    }

    /**
     * @return mixed[]
     */
    public function context() : array
    {
        return $this->context;
    }

    public function occurredAt() : DateTimeImmutable
    {
        return $this->occurredAt;
    }

    /**
     * @return mixed[]
     */
    public function toPayload() : array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'context' => $this->context,
            'roles' => $this->roles,
            'occurredAt' => $this->occurredAt->format('Y-m-d H:i:s'),
        ];
    }
}
