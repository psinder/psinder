<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Infrastructure\Authorization;

use Laminas\Permissions\Rbac\Rbac;
use Sip\Psinder\Security\Application\Authorization;
use Sip\Psinder\Security\Domain\User\Role;
use Sip\Psinder\Security\Domain\User\User;
use function Functional\some;

final class LaminasRbacAuthorization implements Authorization
{
    /** @var Rbac */
    private $rbac;

    public function __construct(Rbac $rbac)
    {
        $this->rbac = $rbac;
    }

    public function isGranted(string $permission, User $user) : bool
    {
        return some($user->roles(), function (Role $role) use ($permission) : void {
            $this->rbac->isGranted($role->identifier(), $permission);
        });
    }
}
