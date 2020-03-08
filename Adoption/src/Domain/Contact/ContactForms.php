<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Contact;

final class ContactForms
{
    /** @var ContactForm[] */
    private array $forms;

    /**
     * @param ContactForm[] $forms
     */
    private function __construct(array $forms)
    {
        $this->forms = $forms;
    }

    public static function fromForms(ContactForm $contactForm, ContactForm ...$contactForms) : self
    {
        return new self([...[$contactForm], ...$contactForms]);
    }

    public static function empty() : self
    {
        return new self([]);
    }

    /**
     * @return ContactForm[]
     */
    public function forms() : array
    {
        return $this->forms;
    }

    public function add(ContactForm $form) : void
    {
        $this->forms[] = $form;
    }
}
