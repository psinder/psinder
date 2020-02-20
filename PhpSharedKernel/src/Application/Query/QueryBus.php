<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Application\Query;

interface QueryBus
{
    /** @return mixed */
    public function execute(Query $query);
}
