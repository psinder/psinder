<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Command;

final class Pet
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $birthdate;

    /** @var string */
    private $breed;

    /** @var string */
    private $sex;

    /** @var string */
    private $type;

    public function __construct(string $id, string $name, string $sex, string $birthdate, string $type, string $breed)
    {
        $this->id        = $id;
        $this->name      = $name;
        $this->sex       = $sex;
        $this->birthdate = $birthdate;
        $this->type      = $type;
        $this->breed     = $breed;
    }

    /**
     * @param string[] $payload
     */
    public static function fromArray(array $payload) : self
    {
        return new self(
            $payload['id'],
            $payload['name'],
            $payload['sex'],
            $payload['birthdate'],
            $payload['type'],
            $payload['breed']
        );
    }

    public function id() : string
    {
        return $this->id;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function birthdate() : string
    {
        return $this->birthdate;
    }

    public function breed() : string
    {
        return $this->breed;
    }

    public function sex() : string
    {
        return $this->sex;
    }

    public function type() : string
    {
        return $this->type;
    }

    /**
     * @return string[]
     */
    public function toArray() : array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sex' => $this->sex,
            'birthdate' => $this->birthdate,
            'type' => $this->type,
            'breed' => $this->breed,
        ];
    }
}
