<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Domain\User;

use Exception;
use Sip\Psinder\SharedKernel\Domain\Email;
use function sprintf;

final class UserNotFound extends Exception
{
    public static function forId(UserId $id) : self
    {
        return new self(sprintf(
            'Account with id %s does not exist',
            $id->toScalar()
        ));
    }

    public static function forEmail(Email $email) : self
    {
        return new self(sprintf(
            'Account with email %s does not exist',
            $email->toString()
        ));
    }
}
