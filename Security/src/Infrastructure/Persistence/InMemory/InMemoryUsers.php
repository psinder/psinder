<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Infrastructure\Persistence\InMemory;

use Sip\Psinder\Security\Domain\User\User;
use Sip\Psinder\Security\Domain\User\UserId;
use Sip\Psinder\Security\Domain\User\UserNotFound;
use Sip\Psinder\Security\Domain\User\Users;
use Sip\Psinder\SharedKernel\Domain\Email;
use Sip\Psinder\SharedKernel\Domain\EventPublisher;
use function Functional\first;

final class InMemoryUsers implements Users
{
    /** @var User[] */
    private array $users;
    private EventPublisher $eventPublisher;

    public function __construct(EventPublisher $eventPublisher)
    {
        $this->users          = [];
        $this->eventPublisher = $eventPublisher;
    }

    public function add(User $account) : void
    {
        $this->users[$account->id()->toScalar()] = $account;

        $account->publishEvents($this->eventPublisher);
    }

    /**
     * @throws UserNotFound
     */
    public function get(UserId $id) : User
    {
        $account = $this->users[$id->toScalar()] ?? null;

        if ($account === null) {
            throw UserNotFound::forId($id);
        }

        return $account;
    }

    public function forEmail(Email $email) : User
    {
        /** @var User|null $user */
        $user = first($this->users, static fn(User $user): bool => $user->email()->equals($email));

        if ($user === null) {
            throw UserNotFound::forEmail($email);
        }

        return $user;
    }
}
