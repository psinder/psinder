<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Sip\Psinder\Adoption\UI\Http\Adopter\PostApplicationRequestHandler;
use Sip\Psinder\Adoption\UI\Http\Adopter\PostRegisterAdopterRequestHandler;
use Sip\Psinder\Adoption\UI\Http\Offer\GetOfferApplicationsRequest;
use Sip\Psinder\Adoption\UI\Http\Offer\GetOfferApplicationsRequestHandler;
use Sip\Psinder\Adoption\UI\Http\Offer\PostApplyForOfferRequestHandler;
use Sip\Psinder\Adoption\UI\Http\Shelter\GetOfferRequestHandler;
use Sip\Psinder\Adoption\UI\Http\Shelter\PostOfferRequest;
use Sip\Psinder\Adoption\UI\Http\Shelter\PostOfferRequestHandler;
use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Sip\Psinder\Adoption\UI\Http\Shelter\PostRegisterShelterRequestHandler;
use Sip\Psinder\SharedKernel\UI\Http\Middleware\Authorization\HasRole;
use Sip\Psinder\SharedKernel\UI\Http\Middleware\AuthorizationMiddleware;
use Sip\Psinder\SharedKernel\UI\Http\Middleware\JsonDeserializeToSpecifiedDTOMiddlewareFactory;

return static function (Application $app, MiddlewareFactory $factory, ContainerInterface $container) : void {
    // Automatic resolver doesn't work with middleware pipes
    $deserializeToDto = $container->get(JsonDeserializeToSpecifiedDTOMiddlewareFactory::class);

    $app->get('/offers/{id}', GetOfferRequestHandler::class);
    $app->post(
        '/offers',
        [
            new AuthorizationMiddleware(new HasRole('shelter')),
            $deserializeToDto(PostOfferRequest::class),
            PostOfferRequestHandler::class
        ]
    );

    $app->post(
        '/offers/{offerId}/applications',
        [
            new AuthorizationMiddleware(new HasRole('adopter')),
            PostApplyForOfferRequestHandler::class
        ]
    );

    $app->post(
        '/shelters',
        PostRegisterShelterRequestHandler::class
    );

    $app->post(
        '/adopters',
        PostRegisterAdopterRequestHandler::class
    );

    $app->get('/offers/{offerId}/applications', GetOfferApplicationsRequestHandler::class);
};
