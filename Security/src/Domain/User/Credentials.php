<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Domain\User;

use Sip\Psinder\SharedKernel\Domain\Email;

final class Credentials
{
    private HashedPassword $password;

    private Email $email;

    private function __construct(Email $email, HashedPassword $password)
    {
        $this->password = $password;
        $this->email    = $email;
    }

    public static function fromEmailAndPassword(Email $email, HashedPassword $password): self
    {
        return new self($email, $password);
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function password(): HashedPassword
    {
        return $this->password;
    }

    public function equals(self $otherCredentials): bool
    {
        return $this->email->equals($otherCredentials->email)
            && $this->password->equals($otherCredentials->password);
    }
}
