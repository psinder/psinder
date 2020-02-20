<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Domain\Identity;

use Assert\Assertion;
use Countable;
use Ds\Vector;
use IteratorAggregate;
use function array_diff;
use function count;
use function Functional\some;
use function implode;

abstract class Identities implements IteratorAggregate, Countable
{
    /** @var Vector|Identity[] */
    private $ids;

    /**
     * @param Identity[] $ids
     */
    public function __construct(array $ids)
    {
        Assertion::notEmpty($ids);
        Assertion::allIsInstanceOf($ids, $this->storedIdentityClass());

        $this->ids = new Vector();

        foreach ($ids as $id) {
            $this->add($id);
        }
    }

    /**
     * @return Identity[]
     */
    public function getIterator() : iterable
    {
        return $this->ids;
    }

    public function count() : int
    {
        return count($this->ids);
    }

    private function add(Identity $id) : void
    {
        if ($this->exists($id)) {
            return;
        }

        $this->ids->push($id);
    }

    public function toString() : string
    {
        return implode(',', $this->toScalarArray());
    }

    /**
     * @return mixed[]
     */
    public function toScalarArray() : array
    {
        return $this->ids->map(static function (Identity $identity) {
            return $identity->toScalar();
        })->toArray();
    }

    public function equals(Identities $otherServices) : bool
    {
        return $this->storedIdentityClass() === $otherServices->storedIdentityClass()
            && count(array_diff($this->toScalarArray(), $otherServices->toScalarArray())) === 0;
    }

    abstract public function storedIdentityClass() : string;

    public function exists(Identity $id) : bool
    {
        return some($this->ids, static function (Identity $identity) use ($id) {
            return $identity->equals($id);
        });
    }
}
