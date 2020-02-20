<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Query;

final class PetDetails
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
