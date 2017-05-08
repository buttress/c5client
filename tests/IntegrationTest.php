<?php

namespace Buttress\ConcreteClient;

use Buttress\ConcreteClient\Adapter\Version6Adapter;
use Buttress\ConcreteClient\Adapter\Version7Adapter;
use Buttress\ConcreteClient\Adapter\Version8Adapter;

class IntegrationTest extends TestCase
{

    /**
     * @runInSeparateProcess
     */
    public function testV6()
    {
        $directory = $this->requireFixture('v6');
        if (!file_exists($directory . '/config/site.php')) {
            $this->markTestIncomplete('Version 6 is only supported once installed.');
        }

        $client = new Concrete5(new Version6Adapter());
        $client->connect($directory);

        if (!class_exists(\Loader::class)) {
            $this->fail('Failed to properly connect to version 6. No Loader class available.');
        }
        $this->assertInstanceOf(\InstallController::class, \Loader::controller('/install'));
    }

    /**
     * @runInSeparateProcess
     */
    public function testV7()
    {
        $directory = $this->requireFixture('v7');
        $client = new Concrete5(new Version7Adapter());

        if (!$connection = $client->connect($directory)) {
            $this->fail('Unable to access version 7 connection.');
        }

        $this->assertInstanceOf(\Buttress\ConcreteClient\Connection\ModernConnection::class, $connection);
        $this->assertInstanceOf(\Concrete\Core\Application\Application::class, $connection->getApplication());
    }

    /**
     * @runInSeparateProcess
     */
    public function testV8()
    {
        $directory = $this->requireFixture('v8');
        $client = new Concrete5(new Version8Adapter());

        if (!$connection = $client->connect($directory)) {
            $this->fail('Unable to access version 8 connection.');
        }

        $this->assertInstanceOf(\Buttress\ConcreteClient\Connection\ModernConnection::class, $connection);
        $this->assertInstanceOf(\Concrete\Core\Application\Application::class, $connection->getApplication());
    }
}
