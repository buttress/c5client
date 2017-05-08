<?php

namespace Buttress\ConcreteClient;

use Buttress\ConcreteClient\Connection\Connection;
use Buttress\ConcreteClient\Adapter\Adapter;

class Concrete5 implements Client
{

    protected $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Attempt to disconnect
     * (This isn't going to be fully supported for awhile)
     *
     * @param \Buttress\ConcreteClient\Connection\Connection $connection
     * @return bool
     */
    public function disconnect(Connection $connection)
    {
        return $connection->disconnect();
    }

    /**
     * Get a connection to a concrete5 site
     * @param string $path The path to the site to connect to
     * @return Connection
     */
    public function connect($path)
    {
        return $this->adapter->attach($path);
    }
}
