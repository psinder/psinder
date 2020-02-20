<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Application\Query;

interface QueryHandler
{
    /**
     * @return mixed
     */
    public function __invoke(Query $query);
}
