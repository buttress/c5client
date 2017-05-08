<?php

namespace Buttress\ConcreteClient\Transaction;

interface Transaction
{

    public function __invoke(callable $transaction);
}
