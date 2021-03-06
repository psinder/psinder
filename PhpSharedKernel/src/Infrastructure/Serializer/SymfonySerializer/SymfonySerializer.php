<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\Serializer\SymfonySerializer;

use Sip\Psinder\SharedKernel\Infrastructure\Serializer\Serializer;
use Symfony\Component\Serializer\Serializer as SymfonySerializerComponent;

final class SymfonySerializer implements Serializer
{
    private SymfonySerializerComponent $serializer;

    private string $format;

    public function __construct(SymfonySerializerComponent $serializer, string $format)
    {
        $this->serializer = $serializer;
        $this->format     = $format;
    }

    /** @param mixed[]|object $value */
    public function serialize($value): string
    {
        return $this->serializer->serialize($value, $this->format);
    }

    public function deserialize(string $value, string $type): object
    {
        return (object) $this->serializer->deserialize($value, $type, $this->format);
    }
}
