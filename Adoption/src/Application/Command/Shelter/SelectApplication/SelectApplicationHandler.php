<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Command\Shelter\SelectApplication;

use Sip\Psinder\Adoption\Domain\Adopter\AdopterId;
use Sip\Psinder\Adoption\Domain\Offer\OfferId;
use Sip\Psinder\Adoption\Domain\Offer\Offers;
use Sip\Psinder\SharedKernel\Application\Command\Command;
use Sip\Psinder\SharedKernel\Application\Command\CommandHandler;
use function assert;

final class SelectApplicationHandler implements CommandHandler
{
    /** @var Offers */
    private $offers;

    public function __construct(Offers $offers)
    {
        $this->offers = $offers;
    }

    public function __invoke(Command $command) : void
    {
        assert($command instanceof SelectApplication);

        $offerId   = new OfferId($command->offerId());
        $adopterId = new AdopterId($command->adopterId());

        $offer = $this->offers->get($offerId);

        $offer->selectApplication($adopterId);

        $this->offers->update($offer);
    }
}
