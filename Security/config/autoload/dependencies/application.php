<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Sip\Psinder\Security\Application\PasswordHasher;
use Sip\Psinder\Security\Application\UseCase\RegisterUser;
use Sip\Psinder\Security\Domain\User\Users;

return [
    'dependencies' => [
        'factories'  => [
            RegisterUser::class => static function (ContainerInterface $container) : RegisterUser {
                return new RegisterUser(
                    $container->get(Users::class),
                    $container->get(PasswordHasher::class)
                );
            },
        ],
    ],
];
