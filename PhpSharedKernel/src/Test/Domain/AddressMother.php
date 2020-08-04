<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Test\Domain;

use Sip\Psinder\SharedKernel\Domain\Address;

final class AddressMother
{
    public static function example(): Address
    {
        return new Address(
            'Foo',
            '1/2',
            '00-000',
            'Bar'
        );
    }
}
