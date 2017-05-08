<?php

namespace Buttress\ConcreteClient\Transaction;

use Buttress\ConcreteClient\TestCase;

class TransactionTraitTest extends TestCase
{

    /**
     * @expectedException \Buttress\ConcreteClient\Exception\TransactionException
     * @expectedExceptionMessageRegExp ~Transaction exited prematurely~
     */
    public function testDetectsExits()
    {
        $this->markTestSkipped('PHP doesn\'t support catching exceptions thrown from __destruct');

        // If it did, our test would look something like this
        $mock = $this->getMockForTrait(TransactionTrait::class);
        $mock->setTransacting(true);
        unset($mock);
    }

    /**
     * @expectedException \Buttress\ConcreteClient\Exception\TransactionException
     * @expectedExceptionMessageRegExp ~Transaction raised an exception~
     */
    public function testDetectsExceptions()
    {
        $mock = $this->getMockForTrait(TransactionTrait::class);
        $mock(function () {
            throw new \Exception('Test');
        });
    }

    /**
     * @requires PHP7
     * @expectedException \Buttress\ConcreteClient\Exception\TransactionException
     * @expectedExceptionMessageRegExp ~Transaction raised an exception~
     */
    public function testDetectsThrowable()
    {
        $mock = $this->getMockForTrait(TransactionTrait::class);
        $mock(function ($variableThatDoesntGetDefined) {
        });
    }
}
