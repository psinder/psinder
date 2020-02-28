<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Domain\User;

use Sip\Psinder\SharedKernel\Domain\Email;

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
    public function forEmail(Email $email) : User;
}
