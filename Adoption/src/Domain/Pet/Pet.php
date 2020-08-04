<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Pet;

use Sip\Psinder\SharedKernel\Domain\Birthdate;

/** @final */
class Pet
{
    private PetId $id;
    private PetName $name;
    private Birthdate $birthdate;
    private PetBreed $breed;
    private PetSex $sex;

    private function __construct(PetId $id, PetName $name, PetSex $sex, Birthdate $birthdate, PetBreed $breed)
    {
        $this->id        = $id;
        $this->name      = $name;
        $this->birthdate = $birthdate;
        $this->breed     = $breed;
        $this->sex       = $sex;
    }

    public static function register(
        PetId $id,
        PetName $name,
        PetSex $sex,
        Birthdate $birthdate,
        PetBreed $breed
    ): self {
        return new self($id, $name, $sex, $birthdate, $breed);
    }

    public function id(): PetId
    {
        return $this->id;
    }

    public function name(): PetName
    {
        return $this->name;
    }

    public function birthdate(): Birthdate
    {
        return $this->birthdate;
    }

    public function breed(): PetBreed
    {
        return $this->breed;
    }

    public function sex(): PetSex
    {
        return $this->sex;
    }

    /**
     * @return string[]
     */
    public function toPayload(): array
    {
        return [
            'id' => $this->id()->toScalar(),
            'name' => $this->name()->toString(),
            'sex' => $this->sex()->toString(),
            'birthdate' => $this->birthdate()->toString(),
            'type' => $this->breed()->type()->name(),
            'breed' => $this->breed()->name(),
        ];
    }
}
