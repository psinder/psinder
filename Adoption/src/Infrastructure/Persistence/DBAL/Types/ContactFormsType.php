<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Infrastructure\Persistence\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Sip\Psinder\Adoption\Domain\Contact\ContactForm;
use Sip\Psinder\Adoption\Domain\Contact\ContactForms;
use Sip\Psinder\SharedKernel\Infrastructure\Persistence\DBAL\Types\JsonType;

use function Functional\map;

final class ContactFormsType extends JsonType
{
    public static function name(): string
    {
        return 'ContactForms';
    }

    /**
     * @param mixed $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        if ($value instanceof ContactForms) {
            $value = map($value->forms(), static fn (ContactForm $form): array => $form->toArray());
        }

        return parent::convertToDatabaseValue($value, $platform);
    }

    /**
     * @param mixed $value
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ContactForms
    {
        $value = parent::convertToPHPValue($value, $platform);

        return ContactFormAbstractFactory::create($value);
    }
}
