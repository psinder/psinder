<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\Persistence\DBAL\Types;

use Sip\Psinder\SharedKernel\Domain\Gender;

final class GenderType extends FromStringableVOType
{
    protected function voClass() : string
    {
        return Gender::class;
    }

    protected function convertToString(object $value) : string
    {
        if ($value instanceof Gender) {
            return $value->toString();
        }
        return (string) $value;
    }

    public static function name() : string
    {
        return 'Gender';
    }
}
