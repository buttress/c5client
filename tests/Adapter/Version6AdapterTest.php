<?php

namespace Buttress\ConcreteClient\Adapter;

use Buttress\ConcreteClient\Connection\Connection;
use Buttress\ConcreteClient\TestCase;

/**
 * @requires PHP5
 */
class Version6AdapterTest extends TestCase
{

    /**
     * @runInSeparateProcess
     */
    public function testAttaches()
    {
        $fixture = $this->requireFixture('adapter/v6/Installed');

        $adapter = new Version6Adapter();
        $connection = $adapter->attach($fixture);

        $GLOBALS['loaded'] = new \ArrayObject();
        $this->assertInstanceOf(Connection::class, $connection);
        $this->assertTrue(defined('DISPATCHED') && DISPATCHED);
    }

    /**
     * @requires PHP7
     * @expectedException \Buttress\ConcreteClient\Exception\VersionMismatchException
     * @expectedExceptionMessageRegExp ~PHP~
     */
    public function testFailsGracefullyInPHP7()
    {
        $fixture = $this->requireFixture('adapter/v6/NotInstalled');
        $adapter = new Version6Adapter();
        $adapter->attach($fixture);
    }

    /**
     * @expectedException \Buttress\ConcreteClient\Exception\RuntimeException
     * @expectedExceptionMessageRegExp ~before installing~
     * @runInSeparateProcess
     */
    public function testFailsGracefullyWhenNotInstalled()
    {
        $fixture = $this->requireFixture('adapter/v6/NotInstalled');
        $adapter = new Version6Adapter();
        $adapter->attach($fixture);
    }

    /**
     * @expectedException \Buttress\ConcreteClient\Exception\RuntimeException
     * @expectedExceptionMessageRegExp ~after headers are sent~
     */
    public function testFailsGracefullyWhenHeadersSent()
    {
        echo "";
        $fixture = $this->requireFixture('adapter/v6/NotInstalled');
        $adapter = new Version6Adapter();
        $adapter->attach($fixture);
    }
}
