<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Application;

use Sip\Psinder\Security\Domain\User\User;

interface Authorization
{
    public function isGranted(string $permission, User $userId) : bool;
}
