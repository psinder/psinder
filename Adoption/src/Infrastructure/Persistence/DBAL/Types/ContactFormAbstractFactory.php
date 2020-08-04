<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Infrastructure\Persistence\DBAL\Types;

use InvalidArgumentException;
use Sip\Psinder\Adoption\Domain\Contact\ContactEmail;
use Sip\Psinder\Adoption\Domain\Contact\ContactForms;
use Sip\Psinder\Adoption\Domain\Contact\ContactPhone;
use Sip\Psinder\SharedKernel\Domain\Email;
use Sip\Psinder\SharedKernel\Domain\Phone;

use function sprintf;

final class ContactFormAbstractFactory
{
    /**
     * @param mixed[] $value
     */
    public static function create(array $value): ContactForms
    {
        $forms = [];

        foreach ($value as $item) {
            switch ($item['type']) {
                case ContactEmail::type():
                    $forms[] = ContactEmail::fromEmail(Email::fromString($item['email']));
                    break;
                case ContactPhone::type():
                    $forms[] = ContactPhone::fromPhone(Phone::fromPrefixAndNumber($item['prefix'], $item['number']));
                    break;
                default:
                    throw new InvalidArgumentException(sprintf(
                        'Invalid contact form type %s',
                        $item['type']
                    ));
            }
        }

        return ContactForms::fromForms(...$forms);
    }
}
