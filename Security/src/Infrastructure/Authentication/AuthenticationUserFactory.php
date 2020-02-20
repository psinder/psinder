<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Infrastructure\Authentication;

use Mezzio\Authentication\UserInterface;
use Psr\Container\ContainerInterface;

final class AuthenticationUserFactory
{
    public function __invoke(ContainerInterface $container) : callable
    {
        return static function (string $identity, array $roles = [], array $details = []) : UserInterface {
            return new AuthenticationUser($identity, $roles, $details);
        };
    }
}
