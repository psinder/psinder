<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Contact;

use Sip\Psinder\SharedKernel\Domain\Phone;

final class ContactPhone implements ContactForm
{
    private Phone $phone;

    private function __construct(Phone $phone)
    {
        $this->phone = $phone;
    }

    public static function fromPhone(Phone $phone): self
    {
        return new self($phone);
    }

    public function equals(ContactForm $otherForm): bool
    {
        return $otherForm instanceof self
            && $this->phone->equals($otherForm->phone);
    }

    public function value(): string
    {
        return $this->phone->toString();
    }

    public static function type(): string
    {
        return 'phone';
    }

    /**
     * @return mixed[]
     */
    public function toArray(): array
    {
        return [
            'type' => self::type(),
            'prefix' => $this->phone->prefix(),
            'number' => $this->phone->number(),
        ];
    }
}
