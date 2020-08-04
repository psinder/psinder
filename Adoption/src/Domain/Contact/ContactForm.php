<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Contact;

interface ContactForm
{
    public function equals(ContactForm $otherForm): bool;

    public function value(): string;

    public static function type(): string;

    /**
     * @return mixed[]
     */
    public function toArray(): array;
}
