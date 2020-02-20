<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Domain\Transfer;

use Ramsey\Uuid\Uuid;
use Sip\Psinder\Adoption\Domain\Adopter\AdopterId;
use Sip\Psinder\Adoption\Domain\Transfer\Transfer;
use Sip\Psinder\Adoption\Domain\Transfer\TransferId;
use Sip\Psinder\Adoption\Test\Domain\Adopter\AdopterMother;
use Sip\Psinder\Adoption\Test\Domain\Offer\OfferMother;
use Sip\Psinder\Adoption\Test\Domain\Pet\PetMother;

final class TransferMother
{
    public const EXAMPLE_ID = '71794ecb-0f57-4b4b-bc16-880ad85876c7';

    public static function randomId() : TransferId
    {
        return new TransferId(Uuid::uuid4()->toString());
    }

    public static function exampleId() : TransferId
    {
        return new TransferId(self::EXAMPLE_ID);
    }

    public static function example() : Transfer
    {
        return Transfer::schedule(
            self::exampleId(),
            OfferMother::exampleId(),
            PetMother::example(),
            AdopterMother::exampleId()
        );
    }

    public static function withAdopterId(AdopterId $adopterId) : Transfer
    {
        return Transfer::schedule(
            self::exampleId(),
            OfferMother::exampleId(),
            PetMother::example(),
            $adopterId
        );
    }
}
