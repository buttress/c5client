<?php

namespace Buttress\ConcreteClient\Connection;

use Buttress\ConcreteClient\TestCase;

class LegacyConnectionTest extends TestCase
{

    /**
     * @runInSeparateProcess
     */
    public function testDetectsConnection()
    {
        $connection = new LegacyConnection();
        $this->assertFalse($connection->isConnected());

        // Define the class that legacyconnection uses to detect
        class_alias(static::class, \Concrete5_Model_Collection::class);
        $this->assertTrue($connection->isConnected());
    }

    /**
     * @runInSeparateProcess
     */
    public function testFailsToDisconnectIfNotConnected()
    {
        $connection = new LegacyConnection();
        $this->assertFalse($connection->disconnect());

        // Define the class that legacyconnection uses to detect
        class_alias(static::class, \Concrete5_Model_Collection::class);
        $this->assertTrue($connection->disconnect());
    }
}
