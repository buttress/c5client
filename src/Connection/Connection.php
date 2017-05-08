<?php

namespace Buttress\ConcreteClient\Connection;

interface Connection
{

    /**
     * Determine if this connection is connected
     * @return mixed
     */
    public function isConnected();

    /**
     * Disconnect a connection
     * @return bool Success or failure
     */
    public function disconnect();
}
