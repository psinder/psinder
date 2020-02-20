<?php

declare(strict_types=1);

namespace DoctrineFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Sip\Psinder\Adoption\Domain\Shelter\Shelter;
use Sip\Psinder\Adoption\Domain\Shelter\ShelterId;
use Sip\Psinder\Adoption\Domain\Shelter\ShelterName;
use Sip\Psinder\SharedKernel\Domain\Email;
use Sip\Psinder\SharedKernel\Test\Domain\AddressMother;

final class ShelterFixture extends AbstractFixture
{
    public const EXAMPLE_ID = 'baec7e53-bbc9-4537-9541-d6a8df844c6a';

    public function load(ObjectManager $manager)
    {
        $shelters = [
            Shelter::register(
                new ShelterId(self::EXAMPLE_ID),
                ShelterName::fromString('example'),
                AddressMother::example(),
                new Email('example@shelter.com')
            )
        ];

        foreach ($shelters as $shelter) {
            $manager->persist($shelter);
        }

        $manager->flush();
    }
}
