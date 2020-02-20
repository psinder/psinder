<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\Serializer\SymfonySerializer;

use Sip\Psinder\SharedKernel\Infrastructure\Serializer\Serializer;
use Symfony\Component\Serializer\Serializer as SymfonySerializerComponent;

final class SymfonySerializer implements Serializer
{
    /** @var SymfonySerializerComponent */
    private $serializer;

    /** @var string */
    private $format;

    public function __construct(SymfonySerializerComponent $serializer, string $format)
    {
        $this->serializer = $serializer;
        $this->format     = $format;
    }

    public function serialize(object $value) : string
    {
        return $this->serializer->serialize($value, $this->format);
    }

    public function deserialize(string $value, string $type) : object
    {
        return $this->serializer->deserialize($value, $type, $this->format);
    }
}
