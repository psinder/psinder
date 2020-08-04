<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Command\Shelter\PostOffer;

use Assert\Assertion;
use Sip\Psinder\Adoption\Application\Command\PetFactory;
use Sip\Psinder\Adoption\Domain\Offer\Offer;
use Sip\Psinder\Adoption\Domain\Offer\OfferId;
use Sip\Psinder\Adoption\Domain\Offer\Offers;
use Sip\Psinder\Adoption\Domain\Shelter\ShelterId;
use Sip\Psinder\Adoption\Domain\Shelter\Shelters;
use Sip\Psinder\SharedKernel\Application\Command\Command;
use Sip\Psinder\SharedKernel\Application\Command\CommandHandler;

use function assert;
use function sprintf;

final class PostOfferHandler implements CommandHandler
{
    private Shelters $shelters;

    private PetFactory $petFactory;

    private Offers $offers;

    public function __construct(Shelters $shelters, Offers $offers, PetFactory $petFactory)
    {
        $this->shelters   = $shelters;
        $this->petFactory = $petFactory;
        $this->offers     = $offers;
    }

    public function __invoke(Command $command): void
    {
        assert($command instanceof PostOffer);

        $shelterId = new ShelterId($command->shelterId());

        $shelterExists = $this->shelters->exists($shelterId);

        Assertion::true($shelterExists, sprintf('Given shelter %s does not exist', $shelterId->toScalar()));

        $pet = $this->petFactory->create($command->pet());

        $offer = Offer::post(
            new OfferId($command->offerId()),
            $shelterId,
            $pet
        );

        $this->offers->create($offer);
    }
}
