<?php

namespace Buttress\ConcreteClient\Adapter;

use Buttress\ConcreteClient\Connection\ModernConnection;

class Version8Adapter extends ModernAdapter
{

    /**
     * Get the connection to connect with
     * @return \Buttress\ConcreteClient\Connection\ModernConnection
     */
    protected function createConnection()
    {
        return new ModernConnection();
    }
}
