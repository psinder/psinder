<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\Serializer\SymfonySerializer;

use Sip\Psinder\SharedKernel\Domain\PayloadableEvent;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class PayloadableEventNormalizer implements NormalizerInterface
{
    /**
     * @param mixed   $object
     * @param string  $format
     * @param mixed[] $context
     *
     * @return mixed[]|string|int|float|bool|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        if ($object instanceof PayloadableEvent) {
            return $object->toPayload();
        }

        return $object;
    }

    /**
     * @param mixed  $data
     * @param string $format
     */
    public function supportsNormalization($data, $format = null) : bool
    {
        return $data instanceof PayloadableEvent;
    }
}
