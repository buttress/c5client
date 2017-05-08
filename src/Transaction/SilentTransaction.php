<?php

namespace Buttress\ConcreteClient\Transaction;

class SilentTransaction implements Transaction
{
    use TransactionTrait;

    public function __invoke(callable $transaction)
    {
        ob_start();
        $result = $this->handleTransaction($transaction);
        ob_end_clean();

        return $result;
    }
}
