<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Sip\Psinder\Adoption\UI\Http\Shelter\GetOfferRequestHandler;
use Sip\Psinder\Adoption\UI\Http\Shelter\PostOfferRequestHandler;
use Mezzio\Application;
use Mezzio\MiddlewareFactory;

return static function (Application $app, MiddlewareFactory $factory, ContainerInterface $container) : void {
    $app->get('/offers/{id}', GetOfferRequestHandler::class);
    $app->post('/offers', PostOfferRequestHandler::class);
};
