<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Transfer;

interface Transfers
{
    /** @throws TransferNotFound */
    public function get(TransferId $id) : Transfer;
    public function create(Transfer $transfer) : void;
    /** @throws TransferNotFound */
    public function update(Transfer $transfer) : void;
}
