<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Command\Adopter\GivePet;

use Sip\Psinder\Adoption\Application\Command\PetFactory;
use Sip\Psinder\Adoption\Domain\Adopter\AdopterId;
use Sip\Psinder\Adoption\Domain\Adopter\Adopters;
use Sip\Psinder\SharedKernel\Application\Command\Command;
use Sip\Psinder\SharedKernel\Application\Command\CommandHandler;
use function assert;

final class GivePetHandler implements CommandHandler
{
    private Adopters $adopters;

    private PetFactory $petFactory;

    public function __construct(Adopters $adopters, PetFactory $petFactory)
    {
        $this->adopters   = $adopters;
        $this->petFactory = $petFactory;
    }

    public function __invoke(Command $command) : void
    {
        assert($command instanceof GivePet);

        $adopterId = new AdopterId($command->adopterId());

        $adopter = $this->adopters->get($adopterId);

        $pet = $this->petFactory->create($command->pet());

        $adopter->receivePet($pet);

        $this->adopters->update($adopter);
    }
}
