<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Test;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Application;

abstract class ExpressiveFunctionalTestCase extends ExpressiveIntegrationTestCase implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        return $this->get(Application::class)
            ->handle($request);
    }
}
