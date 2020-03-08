<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Infrastructure\Persistence\DBAL\Types\Offer;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Sip\Psinder\Adoption\Domain\Adopter\AdopterId;
use Sip\Psinder\Adoption\Domain\Offer\Application\Application;
use Sip\Psinder\SharedKernel\Infrastructure\Persistence\DBAL\Types\JsonType;
use function Functional\map;

final class OfferApplicationsType extends JsonType
{
    public static function name() : string
    {
        return 'OfferApplications';
    }

    /**
     * @param mixed $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform) : ?string
    {
        if ($value === null) {
            return null;
        }

        $applicationsData = map($value, static fn(Application $application): array => [
            'adopterId' => $application->adopterId()->toScalar(),
        ]);

        return parent::convertToDatabaseValue($applicationsData, $platform);
    }

    /**
     * @param mixed $value
     *
     * @return Application[]
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) : array
    {
        $value = parent::convertToPHPValue($value, $platform);

        return map(
            $value,
            static function (array $applicationData) : Application {
                return Application::prepare(new AdopterId($applicationData['adopterId']));
            }
        );
    }
}
