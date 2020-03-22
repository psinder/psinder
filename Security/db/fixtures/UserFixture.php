<?php

declare(strict_types=1);

namespace DoctrineFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Sip\Psinder\Adoption\Domain\Shelter\Shelter;
use Sip\Psinder\Adoption\Domain\Shelter\ShelterId;
use Sip\Psinder\Adoption\Domain\Shelter\ShelterName;
use Sip\Psinder\Security\Domain\User\Credentials;
use Sip\Psinder\Security\Domain\User\HashedPassword;
use Sip\Psinder\Security\Domain\User\Role;
use Sip\Psinder\Security\Domain\User\Roles;
use Sip\Psinder\Security\Domain\User\User;
use Sip\Psinder\Security\Domain\User\UserId;
use Sip\Psinder\Security\Infrastructure\Sha256PasswordHasher;
use Sip\Psinder\SharedKernel\Domain\Email;
use Sip\Psinder\SharedKernel\Test\Domain\AddressMother;

final class UserFixture extends AbstractFixture
{
    public const EXAMPLE_SHELTER_ID = 'baec7e53-bbc9-4537-9541-d6a8df844c6a';
    public const EXAMPLE_ADOPTER_ID = 'cc3cfe18-584c-4974-9c49-df331d198944';

    public function load(ObjectManager $manager)
    {
        $shelters = [
            User::register(
                new UserId(self::EXAMPLE_SHELTER_ID),
                new Roles([Role::fromString('shelter')]),
                Credentials::fromEmailAndPassword(
                    Email::fromString('example@shelter.com'),
                    (new Sha256PasswordHasher())->hash(
                        'foobar',
                        self::EXAMPLE_SHELTER_ID
                    )
                )
            )
        ];

        foreach ($shelters as $shelter) {
            $manager->persist($shelter);
        }

        $adopters = [
            User::register(
                new UserId(self::EXAMPLE_ADOPTER_ID),
                new Roles([Role::fromString('adopter')]),
                Credentials::fromEmailAndPassword(
                    Email::fromString('example@adopter.com'),
                    (new Sha256PasswordHasher())->hash(
                        'baz',
                        self::EXAMPLE_ADOPTER_ID
                    )
                )
            )
        ];

        foreach ($adopters as $adopters) {
            $manager->persist($adopters);
        }

        $manager->flush();
    }
}
