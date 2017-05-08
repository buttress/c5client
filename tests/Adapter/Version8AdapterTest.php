<?php

namespace Buttress\ConcreteClient\Adapter;

use Buttress\ConcreteClient\Connection\ModernConnection;
use Buttress\ConcreteClient\TestCase;

class Version8AdapterTest extends TestCase
{

    /**
     * @runInSeparateProcess
     */
    public function testAttaches()
    {
        $adapter = new Version8Adapter();
        $connection = $adapter->attach($this->requireFixture('adapter/v8'));

        $this->assertInstanceOf(ModernConnection::class, $connection);

        // Make sure we got our fixture back
        $this->assertInstanceOf(\Concrete\Core\Application\Application::class, $connection->getApplication());

        // Make sure we booted up
        $this->assertTrue($connection->getApplication()->booted);
    }
}
