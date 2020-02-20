<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Command\Shelter\RegisterShelter;

use Sip\Psinder\Adoption\Application\Command\Shelter\ShelterFactory;
use Sip\Psinder\Adoption\Domain\Shelter\Shelters;
use Sip\Psinder\SharedKernel\Application\Command\Command;
use Sip\Psinder\SharedKernel\Application\Command\CommandHandler;
use function assert;

final class RegisterShelterHandler implements CommandHandler
{
    /** @var Shelters */
    private $shelters;

    /** @var ShelterFactory */
    private $factory;

    public function __construct(Shelters $shelters, ShelterFactory $factory)
    {
        $this->shelters = $shelters;
        $this->factory  = $factory;
    }

    public function __invoke(Command $command) : void
    {
        assert($command instanceof RegisterShelter);

        $shelter = $this->factory->create(
            $command->id(),
            $command->name(),
            $command->address(),
            $command->email()
        );

        $this->shelters->create($shelter);
    }
}
