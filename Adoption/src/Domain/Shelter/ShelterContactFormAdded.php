<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Shelter;

use DateTimeImmutable;
use Sip\Psinder\Adoption\Domain\Contact\ContactForm;
use Sip\Psinder\SharedKernel\Domain\Event;

final class ShelterContactFormAdded implements Event
{
    private string $shelterId;

    private string $name;

    private string $value;

    private DateTimeImmutable $occurredAt;

    public function __construct(string $shelterId, string $name, string $value, DateTimeImmutable $occurredAt)
    {
        $this->shelterId  = $shelterId;
        $this->name       = $name;
        $this->value      = $value;
        $this->occurredAt = $occurredAt;
    }

    public static function occur(ShelterId $shelterId, ContactForm $form) : self
    {
        return new self($shelterId->toScalar(), $form::type(), $form->value(), new DateTimeImmutable());
    }

    public function shelterId() : string
    {
        return $this->shelterId;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function value() : string
    {
        return $this->value;
    }

    public function occurredAt() : DateTimeImmutable
    {
        return $this->occurredAt;
    }
}
