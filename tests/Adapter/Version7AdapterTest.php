<?php

namespace Buttress\ConcreteClient\Adapter;

use Buttress\ConcreteClient\Connection\ModernConnection;
use Buttress\ConcreteClient\TestCase;

class Version7AdapterTest extends TestCase
{

    /**
     * @runInSeparateProcess
     */
    public function testAttaches()
    {
        $adapter = new Version7Adapter();
        $connection = $adapter->attach($this->requireFixture('adapter/v7'));

        $this->assertInstanceOf(ModernConnection::class, $connection);
        $this->assertInstanceOf(\Concrete\Core\Application\Application::class, $connection->getApplication());
    }
}
