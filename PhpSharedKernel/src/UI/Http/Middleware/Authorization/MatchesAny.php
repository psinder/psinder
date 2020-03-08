<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\UI\Http\Middleware\Authorization;

use Sip\Psinder\SharedKernel\UI\Http\Middleware\Authentication\AuthenticatedUser;
use function Functional\some;

final class MatchesAny implements AuthorizationRule
{
    /** @var AuthorizationRule[] */
    private array $rules;

    public function isAuthorized(AuthenticatedUser $user) : bool
    {
        return some($this->rules, fn(AuthorizationRule $rule) => $rule->isAuthorized($user));
    }
}
