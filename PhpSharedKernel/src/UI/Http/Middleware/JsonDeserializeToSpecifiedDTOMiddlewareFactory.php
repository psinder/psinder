<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\UI\Http\Middleware;

use Sip\Psinder\SharedKernel\Infrastructure\Serializer\Serializer;

final class JsonDeserializeToSpecifiedDTOMiddlewareFactory
{
    private Serializer $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    public function __invoke(string $dto): JsonDeserializeMiddleware
    {
        return new JsonDeserializeMiddleware(
            $this->serializer,
            new FixedRequestPayloadTargetDTOResolver($dto),
        );
    }
}
