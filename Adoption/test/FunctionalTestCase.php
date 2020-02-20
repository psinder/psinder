<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test;

use Helmich\Psr7Assert\Psr7Assertions;
use Mezzio\MiddlewareFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Application;

abstract class FunctionalTestCase extends TransactionalTestCase
{
    use Psr7Assertions;

    protected function containerPath() : string
    {
        return __DIR__ . '/../config/container.php';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $application = $this->container->get(Application::class);
        $factory = $this->container->get(MiddlewareFactory::class);
        (require __DIR__ . '/../config/pipeline.php')($application, $factory, $this->container);
        (require __DIR__ . '/../config/routes.php')($application, $factory, $this->container);

        $this->em()->beginTransaction();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->get(Application::class)
            ->handle($request);
    }
}
