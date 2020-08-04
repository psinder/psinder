<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Domain\Identity;

use ArrayIterator;
use Assert\Assertion;
use Countable;
use IteratorAggregate;
use Traversable;

use function array_diff;
use function count;
use function Functional\map;
use function Functional\some;
use function implode;

/**
 * @implements IteratorAggregate<Identity>
 */
abstract class Identities implements IteratorAggregate, Countable
{
    /** @var Identity[] */
    private array $ids;

    /**
     * @param Identity[] $ids
     */
    public function __construct(array $ids)
    {
        Assertion::notEmpty($ids);
        Assertion::allIsInstanceOf($ids, $this->storedIdentityClass());

        $this->ids = [];

        foreach ($ids as $id) {
            $this->add($id);
        }
    }

    /**
     * @return Identity[]
     *
     * @phpstan-return Traversable<Identity>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->ids);
    }

    public function count(): int
    {
        return count($this->ids);
    }

    private function add(Identity $id): void
    {
        if ($this->exists($id)) {
            return;
        }

        $this->ids[] = $id;
    }

    public function toString(): string
    {
        return implode(',', $this->toScalarArray());
    }

    /**
     * @return mixed[]
     */
    public function toScalarArray(): array
    {
        return map($this->ids, static fn (Identity $identity) => $identity->toScalar());
    }

    public function equals(Identities $otherServices): bool
    {
        return $this->storedIdentityClass() === $otherServices->storedIdentityClass()
            && count(array_diff($this->toScalarArray(), $otherServices->toScalarArray())) === 0;
    }

    abstract public function storedIdentityClass(): string;

    public function exists(Identity $id): bool
    {
        return some($this->ids, static fn (Identity $identity) => $identity->equals($id));
    }
}
