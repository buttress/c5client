<?php

namespace Buttress\ConcreteClient;

use Buttress\ConcreteClient\Connection\Connection;

interface Client
{

    /**
     * Connect to a concrete5 site
     * @param string $path The path to the site to connect to
     * @return \Buttress\ConcreteClient\Connection
     */
    public function connect($path);

    /**
     * Attempt to disconnect
     * (This isn't going to be fully supported for awhile)
     *
     * @param \Buttress\ConcreteClient\Connection\Connection $connection
     * @return bool
     */
    public function disconnect(Connection $connection);
}
