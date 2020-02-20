<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Infrastructure\Persistence\DBAL\Types\User;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Sip\Psinder\Security\Domain\User\Role;
use Sip\Psinder\Security\Domain\User\Roles;
use Sip\Psinder\SharedKernel\Infrastructure\Persistence\DBAL\Types\JsonType;
use function Functional\map;
use function is_array;

final class RolesType extends JsonType
{
    public static function name() : string
    {
        return 'Roles';
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof Roles) {
            $value = map($value, static function (Role $role) : string {
                return $role->identifier();
            });
        }

        return parent::convertToDatabaseValue($value, $platform);
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $value = parent::convertToPHPValue($value, $platform);

        if (is_array($value)) {
            return new Roles(map($value, static function (string $role) : Role {
                return Role::fromString($role);
            }));
        }

        return $value;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform) : bool
    {
        return true;
    }
}
