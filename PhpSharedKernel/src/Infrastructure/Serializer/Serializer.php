<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\Serializer;

interface Serializer
{
    public function serialize(object $value) : string;

    public function deserialize(string $value, string $type) : object;
}
