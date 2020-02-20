<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Presentation\Http;

use Lcobucci\JWT\Builder;
use Sip\Psinder\Security\Domain\User\User;

final class UserTokenFactory
{
    /** @var Builder */
    private $builder;

    /** @var string */
    private $issuer;

    /** @var int */
    private $expiration;

    public function __construct(Builder $builder, string $issuer, int $expiration = 20 * 60)
    {
        $this->builder    = $builder;
        $this->issuer     = $issuer;
        $this->expiration = $expiration;
    }

    public function create(User $user) : string
    {
        return $this->builder
            ->setId($user->id()->toScalar())
            ->setExpiration($this->expiration)
            ->setIssuer($this->issuer)
            ->getToken()
            ->__toString();
    }
}
