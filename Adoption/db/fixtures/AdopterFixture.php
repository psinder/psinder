<?php

declare(strict_types=1);

namespace DoctrineFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Sip\Psinder\Adoption\Domain\Adopter\Adopter;
use Sip\Psinder\Adoption\Domain\Adopter\AdopterId;
use Sip\Psinder\Adoption\Domain\Adopter\AdopterName;
use Sip\Psinder\Adoption\Domain\Shelter\Shelter;
use Sip\Psinder\Adoption\Domain\Shelter\ShelterId;
use Sip\Psinder\Adoption\Domain\Shelter\ShelterName;
use Sip\Psinder\SharedKernel\Domain\Birthdate;
use Sip\Psinder\SharedKernel\Domain\Email;
use Sip\Psinder\SharedKernel\Domain\Gender;
use Sip\Psinder\SharedKernel\Test\Domain\AddressMother;

final class AdopterFixture extends AbstractFixture
{
    public const EXAMPLE_ID = '5c5e43e7-a254-4653-bc51-19f03f2eb3ee';

    public function load(ObjectManager $manager)
    {
        $adopters = [
            Adopter::register(
                new AdopterId(self::EXAMPLE_ID),
                AdopterName::fromFirstAndLastName('John', 'Bean'),
                Birthdate::fromString('2000-01-01'),
                Gender::other(),
                new Email('example@adopter.com')
            )
        ];

        foreach ($adopters as $adopter) {
            $manager->persist($adopter);
        }

        $manager->flush();
    }
}
