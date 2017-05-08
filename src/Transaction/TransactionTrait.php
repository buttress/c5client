<?php

namespace Buttress\ConcreteClient\Transaction;

use Buttress\ConcreteClient\Exception\TransactionException;

trait TransactionTrait
{
    private $transacting = false;

    public function __invoke(callable $transaction)
    {
        return $this->handleTransaction($transaction);
    }

    protected function handleTransaction(callable $transaction)
    {
        $this->transacting = true;
        try {
            $result = $transaction();
        } catch (\Exception $e) {
            $this->transacting = false;
            // Catch any exceptions
            throw new TransactionException('Transaction raised an exception: ' . $e->getMessage(), 500, $e);
        } catch (\Throwable $e) {
            $this->transacting = false;
            // Catch extra stuff in PHP 7+
            throw new TransactionException('Transaction raised an exception: ' . $e->getMessage(), 500, $e);
        }
        $this->transacting = false;

        return $result;
    }

    public function __destruct()
    {
        if ($this->transacting) {
            throw new TransactionException('Transaction exited prematurely.');
        }
    }

    public static function transact(callable $callable)
    {
        $transaction = new static;
        return $transaction($callable);
    }
}
