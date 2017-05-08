<?php
namespace Buttress\ConcreteClient\Transaction;

use Buttress\ConcreteClient\TestCase;

class SimpleTransactionTest extends TestCase
{
    public function testTransacts()
    {
        $transacted = false;
        SimpleTransaction::transact(function () use (&$transacted) {
            $transacted = true;
        });

        $this->assertTrue($transacted);
    }
}
