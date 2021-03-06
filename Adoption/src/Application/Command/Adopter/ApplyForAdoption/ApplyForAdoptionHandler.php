<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Command\Adopter\ApplyForAdoption;

use Sip\Psinder\Adoption\Domain\Adopter\AdopterId;
use Sip\Psinder\Adoption\Domain\Adopter\Adopters;
use Sip\Psinder\Adoption\Domain\Offer\OfferId;
use Sip\Psinder\Adoption\Domain\Offer\Offers;
use Sip\Psinder\SharedKernel\Application\Command\Command;
use Sip\Psinder\SharedKernel\Application\Command\CommandHandler;

use function assert;

final class ApplyForAdoptionHandler implements CommandHandler
{
    private Offers $offers;

    private Adopters $adopters;

    public function __construct(Adopters $adopters, Offers $offers)
    {
        $this->offers   = $offers;
        $this->adopters = $adopters;
    }

    public function __invoke(Command $command): void
    {
        assert($command instanceof ApplyForAdoption);

        $offerId   = new OfferId($command->offerId());
        $adopterId = new AdopterId($command->adopterId());

        // Checks if exists
        $this->adopters->get($adopterId);

        $offer = $this->offers->get($offerId);

        $offer->apply($adopterId);

        $this->offers->update($offer);
    }
}
