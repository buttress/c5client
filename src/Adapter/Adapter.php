<?php

namespace Buttress\ConcreteClient\Adapter;

/**
 * Adapters are used to connect the CLI tool with an existing concrete5 installation
 */
interface Adapter
{

    /**
     * Attach to a concrete5 site
     * @param string $path The path to attach to
     * @return \Buttress\ConcreteClient\Connection\Connection $connection
     */
    public function attach($path);
}
