<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Command\Adopter\RegisterAdopter;

use Sip\Psinder\Adoption\Application\Command\Adopter\AdopterFactory;
use Sip\Psinder\Adoption\Application\Command\UserRegisterer;
use Sip\Psinder\Adoption\Domain\Adopter\Adopters;
use Sip\Psinder\SharedKernel\Application\Command\Command;
use Sip\Psinder\SharedKernel\Application\Command\CommandHandler;
use Sip\Psinder\SharedKernel\Application\Command\TransactionManager;

use function assert;

final class RegisterAdopterHandler implements CommandHandler
{
    private Adopters $adopters;
    private AdopterFactory $factory;
    private UserRegisterer $userRegisterer;
    private TransactionManager $transactionManager;

    public function __construct(
        Adopters $adopters,
        AdopterFactory $factory,
        UserRegisterer $userRegisterer,
        TransactionManager $transactionManager
    ) {
        $this->adopters           = $adopters;
        $this->factory            = $factory;
        $this->userRegisterer     = $userRegisterer;
        $this->transactionManager = $transactionManager;
    }

    public function __invoke(Command $command): void
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

        $this->transactionManager->transactional(function () use ($adopter, $command): void {
            $this->adopters->create($adopter);
            $this->userRegisterer->register(
                $command->id(),
                $command->email(),
                $command->password(),
                ['adopter']
            );
        });
    }
}
