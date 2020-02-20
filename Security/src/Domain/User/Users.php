<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Domain\User;

interface Users
{
    public function add(User $account) : void;

    /**
     * @throws UserNotFound
     */
    public function get(UserId $id) : User;

    /**
     * @throws UserNotFound
     */
    public function forCredentials(Credentials $credentials) : User;
}
