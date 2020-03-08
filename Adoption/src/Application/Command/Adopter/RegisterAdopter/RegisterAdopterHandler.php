<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Command\Adopter\RegisterAdopter;

use Sip\Psinder\Adoption\Application\Command\Adopter\AdopterFactory;
use Sip\Psinder\Adoption\Domain\Adopter\Adopters;
use Sip\Psinder\SharedKernel\Application\Command\Command;
use Sip\Psinder\SharedKernel\Application\Command\CommandHandler;
use function assert;

final class RegisterAdopterHandler implements CommandHandler
{
    private Adopters $adopters;

    private AdopterFactory $factory;

    public function __construct(Adopters $adopters, AdopterFactory $factory)
    {
        $this->adopters = $adopters;
        $this->factory  = $factory;
    }

    public function __invoke(Command $command) : void
    {
        assert($command instanceof RegisterAdopter);

        $adopter = $this->factory->create(
            $command->id(),
            $command->firstName(),
            $command->lastName(),
            $command->birthdate(),
            $command->gender(),
            $command->email()
        );

        $this->adopters->create($adopter);
    }
}
