<?php

namespace Buttress\ConcreteClient\Connection;

use Buttress\ConcreteClient\TestCase;

/**
 * @runTestsInSeparateProcesses
 */
class ModernConnectionTest extends TestCase
{

    public function testConnects()
    {
        // Make it so that we can pass $this as our application
        class_alias(static::class, \Concrete\Core\Application\Application::class);

        $connection = new ModernConnection();
        $this->assertFalse($connection->isConnected());
        $this->assertFalse($connection->disconnect());

        // Make sure the isConnected method works
        $connection->connect($this);
        $this->assertTrue($connection->isConnected());

        // Make sure we stored the application
        $this->assertEquals($this, $connection->getApplication());

        // Can't disconnect twice
        $this->assertTrue($connection->disconnect());
        $this->assertFalse($connection->disconnect());
    }
}
