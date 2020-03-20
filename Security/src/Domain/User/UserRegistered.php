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
    /** @var string[] */
    private array $roles;
    private DateTimeImmutable $occurredAt;
    private string $email;

    /**
     * @param string[] $roles
     */
    private function __construct(string $id, string $email, array $roles, DateTimeImmutable $occurredAt)
    {
        $this->id         = $id;
        $this->roles      = $roles;
        $this->occurredAt = $occurredAt;
        $this->email      = $email;
    }

    public static function occur(UserId $id, Email $email, Roles $roles) : self
    {
        return new self(
            $id->toScalar(),
            $email->toString(),
            $roles->toScalarArray(),
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
            'roles' => $this->roles,
            'occurredAt' => $this->occurredAt->format('Y-m-d H:i:s'),
        ];
    }
}
