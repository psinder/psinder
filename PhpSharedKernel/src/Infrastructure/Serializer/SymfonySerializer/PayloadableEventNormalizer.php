<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\Serializer\SymfonySerializer;

use Sip\Psinder\SharedKernel\Domain\PayloadableEvent;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class PayloadableEventNormalizer implements NormalizerInterface
{
    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     * @param mixed       $object
     * @param mixed[]     $context
     * @param string|null $format
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
     * @param mixed $data
     */
    public function supportsNormalization($data, ?string $format = null): bool
    {
        return $data instanceof PayloadableEvent;
    }
}
