<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Infrastructure\Persistence\ORM;

use Doctrine\ORM\EntityManagerInterface;
use Sip\Psinder\Security\Domain\User\Credentials;
use Sip\Psinder\Security\Domain\User\User;
use Sip\Psinder\Security\Domain\User\UserId;
use Sip\Psinder\Security\Domain\User\UserNotFound;
use Sip\Psinder\Security\Domain\User\Users;
use Sip\Psinder\SharedKernel\Domain\EventPublisher;
use Sip\Psinder\SharedKernel\Infrastructure\Persistence\ORM\ORMCollection;
use function assert;

final class ORMUsers implements Users
{
    /** @var ORMCollection  */
    private $collection;

    public function __construct(EntityManagerInterface $entityManager, EventPublisher $eventPublisher)
    {
        $this->collection = new ORMCollection(
            $entityManager,
            $eventPublisher,
            User::class,
            static function (UserId $id) : UserNotFound {
                return UserNotFound::forId($id);
            }
        );
    }

    /** @throws UserNotFound */
    public function get(UserId $id) : User
    {
        $offer = $this->collection->get($id);

        assert($offer instanceof User);

        return $offer;
    }

    public function add(User $account) : void
    {
        $this->collection->create($account);
    }

    /**
     * @throws UserNotFound
     */
    public function forCredentials(Credentials $credentials) : User
    {
        $qb = $this->collection->entityManager()->createQueryBuilder();

        $qb->select('u')
            ->from(User::class, 'u')
            ->where($qb->expr()->eq('u.email', ':email'))
            ->andWhere($qb->expr()->eq('u.password', ':password'))
            ->setParameter('email', $credentials->email())
            ->setParameter('password', $credentials->password());

        $result = $qb->getQuery()->getOneOrNullResult();

        if ($result === null) {
            throw UserNotFound::forCredentials($credentials);
        }

        return $result;
    }
}
