<?php

namespace Buttress\ConcreteClient\Connection;

interface ConnectionAware
{

    /**
     * Set a connection
     * @param \Buttress\ConcreteClient\Connection\Connection $connection
     */
    public function setConnection(Connection $connection);

    /**
     * Get the connection
     * @return \Buttress\ConcreteClient\Connection\Connection
     */
    public function connection();
}
