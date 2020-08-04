<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Command\Shelter\RegisterShelter;

use Sip\Psinder\Adoption\Application\Command\Shelter\ShelterFactory;
use Sip\Psinder\Adoption\Application\Command\UserRegisterer;
use Sip\Psinder\Adoption\Domain\Shelter\Shelters;
use Sip\Psinder\SharedKernel\Application\Command\Command;
use Sip\Psinder\SharedKernel\Application\Command\CommandHandler;
use Sip\Psinder\SharedKernel\Application\Command\TransactionManager;

use function assert;

final class RegisterShelterHandler implements CommandHandler
{
    private Shelters $shelters;
    private ShelterFactory $factory;
    private UserRegisterer $registerer;
    private TransactionManager $transactionManager;

    public function __construct(
        Shelters $shelters,
        ShelterFactory $factory,
        UserRegisterer $registerer,
        TransactionManager $transactionManager
    ) {
        $this->shelters           = $shelters;
        $this->factory            = $factory;
        $this->registerer         = $registerer;
        $this->transactionManager = $transactionManager;
    }

    public function __invoke(Command $command): void
    {
        assert($command instanceof RegisterShelter);

        $shelter = $this->factory->create(
            $command->id(),
            $command->name(),
            $command->address(),
            $command->email()
        );

        $this->transactionManager->transactional(function () use ($shelter, $command): void {
            $this->shelters->create($shelter);

            $this->registerer->register(
                $command->id(),
                $command->email(),
                $command->password(),
                ['shelter']
            );
        });
    }
}
