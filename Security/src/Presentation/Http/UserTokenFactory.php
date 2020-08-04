<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Presentation\Http;

use Lcobucci\Clock\Clock;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;

final class UserTokenFactory
{
    private Builder $builder;
    private string $issuer;
    private int $expiration;
    private Clock $clock;
    private Key $key;

    public function __construct(
        Key $key,
        Clock $clock,
        Builder $builder,
        string $issuer,
        int $expiration = 20 * 60
    ) {
        $this->builder    = $builder;
        $this->issuer     = $issuer;
        $this->expiration = $expiration;
        $this->clock      = $clock;
        $this->key        = $key;
    }

    /**
     * @param string[] $roles
     */
    public function create(string $userId, array $roles): string
    {
        $now = $this->clock->now()->getTimestamp();

        return $this->builder
            ->identifiedBy($userId)
            ->withClaim('roles', $roles)
            ->expiresAt($now + $this->expiration)
            ->issuedAt($now)
            ->issuedBy($this->issuer)
            ->getToken(new Sha256(), $this->key)
            ->__toString();
    }
}
