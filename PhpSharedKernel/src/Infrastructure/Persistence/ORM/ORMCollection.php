<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\Persistence\ORM;

use Doctrine\ORM\EntityManagerInterface;
use Sip\Psinder\SharedKernel\Domain\AggregateRoot;
use Sip\Psinder\SharedKernel\Domain\EventPublisher;
use Sip\Psinder\SharedKernel\Domain\Identity\Identity;

final class ORMCollection
{
    private EntityManagerInterface $entityManager;

    private EventPublisher $eventPublisher;

    private string $class;

    /** @var callable */
    private $exceptionFactory;

    public function __construct(
        EntityManagerInterface $entityManager,
        EventPublisher $eventPublisher,
        string $class,
        callable $exceptionFactory
    ) {
        $this->entityManager    = $entityManager;
        $this->eventPublisher   = $eventPublisher;
        $this->class            = $class;
        $this->exceptionFactory = $exceptionFactory;
    }

    public function create(AggregateRoot $aggregate) : void
    {
        $this->entityManager->transactional(function () use ($aggregate) : void {
            $this->entityManager->persist($aggregate);
            $this->entityManager->flush();
            $aggregate->publishEvents($this->eventPublisher);
        });
    }

    public function update(AggregateRoot $aggregate) : void
    {
        $id = $aggregate->id();

        if (! $this->exists($id)) {
            throw ($this->exceptionFactory)($id);
        }

        $this->entityManager->transactional(function () use ($aggregate) : void {
            $this->entityManager->flush();
            $aggregate->publishEvents($this->eventPublisher);
        });
    }

    public function get(Identity $id) : ?AggregateRoot
    {
        /** @var AggregateRoot|null $aggregate */
        $aggregate = $this->entityManager->find($this->class, $id->toScalar());

        if ($aggregate === null) {
            throw ($this->exceptionFactory)($id);
        }

        return $aggregate;
    }

    public function exists(Identity $id) : bool
    {
        return $this->entityManager->find($this->class, $id->toScalar()) !== null;
    }

    public function entityManager() : EntityManagerInterface
    {
        return $this->entityManager;
    }
}
