<?php

declare(strict_types = 1);

namespace Sip\Psinder\SharedKernel\Infrastructure\Serializer\SymfonySerializer;

use Sip\Psinder\SharedKernel\Domain\PayloadableEvent;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class PayloadableEventNormalizer implements NormalizerInterface
{
    /**
     * @param PayloadableEvent $object
     */
    public function normalize($object, $format = null, array $context = [])
    {
        return $object->toPayload();
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof PayloadableEvent;
    }
}
