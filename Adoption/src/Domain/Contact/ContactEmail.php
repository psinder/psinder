<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Contact;

use Sip\Psinder\SharedKernel\Domain\Email;

final class ContactEmail implements ContactForm
{
    /** @var Email */
    private $email;

    private function __construct(Email $email)
    {
        $this->email = $email;
    }

    public static function fromEmail(Email $email) : self
    {
        return new self($email);
    }

    public function email() : Email
    {
        return $this->email;
    }

    public function equals(ContactForm $otherForm) : bool
    {
        return $otherForm instanceof self
            && $this->email->equals($otherForm->email);
    }

    public function value() : string
    {
        return $this->email->toString();
    }

    public static function type() : string
    {
        return 'email';
    }

    /**
     * @return mixed[]
     */
    public function toArray() : array
    {
        return [
            'type' => self::type(),
            'email' => $this->email->toString(),
        ];
    }
}
