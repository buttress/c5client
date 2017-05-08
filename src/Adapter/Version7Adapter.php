<?php

namespace Buttress\ConcreteClient\Adapter;

use Buttress\ConcreteClient\Connection\ModernConnection;

class Version7Adapter extends ModernAdapter
{

    /**
     * Get the connection to connect with
     * @return ModernConnection
     */
    protected function createConnection()
    {
        return new ModernConnection();
    }
}
