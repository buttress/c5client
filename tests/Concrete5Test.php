<?php

namespace Buttress\ConcreteClient;

class Concrete5Test extends TestCase
{
    public function testConnects()
    {
        $adapter = $this->getMockForAbstractClass(Adapter\Adapter::class);
        $adapter->expects($this->once())->method('attach')->with('test');

        $client = new Concrete5($adapter);
        $client->connect('test');
    }

    public function testDisconnects()
    {
        $adapter = $this->getMockForAbstractClass(Adapter\Adapter::class);
        $connection = $this->getMockForAbstractClass(Connection\Connection::class);
        $connection->expects($this->once())->method('disconnect');

        $client = new Concrete5($adapter);
        $client->disconnect($connection);
    }
}
