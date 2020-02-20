<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\UI\Http\Middleware;

use Fig\Http\Message\RequestMethodInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Sip\Psinder\SharedKernel\Infrastructure\Serializer\Serializer;
use function in_array;
use function stripos;

final class JsonDeserializeMiddleware implements MiddlewareInterface
{
    /** @var Serializer */
    private $serializer;

    /** @var array */
    private $allowedMethods;

    /** @var array */
    private $allowedContentTypes;

    /** @var RequestPayloadTargetDTOResolver */
    private $targetDTOResolver;

    public function __construct(
        Serializer $serializer,
        RequestPayloadTargetDTOResolver $targetDTOResolver,
        array $allowedMethods = [
            RequestMethodInterface::METHOD_POST,
            RequestMethodInterface::METHOD_PUT,
            RequestMethodInterface::METHOD_PATCH,
        ],
        array $allowedContentTypes = ['application/json']
    ) {
        $this->serializer          = $serializer;
        $this->allowedMethods      = $allowedMethods;
        $this->allowedContentTypes = $allowedContentTypes;
        $this->targetDTOResolver   = $targetDTOResolver;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        if (! $this->shouldDeserialize($request)) {
            return $handler->handle($request);
        }

        $targetDTOClass = $this->targetDTOResolver->resolve($request);

        if ($targetDTOClass === null) {
            return $handler->handle($request);
        }

        $requestObject = $this->serializer->deserialize(
            (string) $request->getBody(),
            $targetDTOClass
        );

        return $handler->handle(
            $request->withAttribute($targetDTOClass, $requestObject)
        );
    }

    private function shouldDeserialize(ServerRequestInterface $request) : bool
    {
        if (! in_array($request->getMethod(), $this->allowedMethods, true)) {
            return false;
        }

        return true;

//        $contentType = $request->getHeaderLine('Content-Type');
//
//        foreach ($this->allowedContentTypes as $allowedType) {
//            if (stripos($contentType, $allowedType) === 0) {
//                return true;
//            }
//        }
//
//        return false;
    }
}
