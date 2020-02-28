<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Domain\User;

use Exception;
use Sip\Psinder\SharedKernel\Domain\Email;
use function sprintf;

final class InvalidCredentials extends Exception
{
    public static function forCredentials(Credentials $credentials): self {
        return new self(sprintf(
            'Given credentials does not match expected for Account with email %s',
            $credentials->email()->toString()
        ));
    }
}
