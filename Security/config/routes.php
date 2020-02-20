<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Sip\Psinder\Security\Presentation\Http\PostLoginRequestHandler;
use Sip\Psinder\Security\Presentation\Http\PostRegisterRequestHandler;
use Mezzio\Application;
use Mezzio\MiddlewareFactory;

return static function (Application $app, MiddlewareFactory $factory, ContainerInterface $container) : void {
    $app->post('/login', PostLoginRequestHandler::class);
    $app->post('/register', PostRegisterRequestHandler::class);
};
