<?php

namespace Buttress\ConcreteClient\Transaction;

use Buttress\ConcreteClient\TestCase;

class SilentTransactionTest extends TestCase
{

    public function testDoesntOutput()
    {
        ob_start();
        SilentTransaction::transact(function () {
            echo 'test';
        });

        $contents = ob_get_contents();
        ob_end_clean();

        $this->assertEmpty($contents);
    }
}
