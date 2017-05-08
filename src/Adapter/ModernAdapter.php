<?php

namespace Buttress\ConcreteClient\Adapter;

use Concrete\Core\Application\Application;

abstract class ModernAdapter implements Adapter
{

    /**
     * Attach to a modern concrete5 site
     * @param string $path
     * @return \Buttress\ConcreteClient\Connection\Connection $connection
     */
    public function attach($path)
    {
        $connection = $this->createConnection();
        $connection->connect($this->resolveApplication($path));

        return $connection;
    }

    /**
     * Get the connection to connect with
     * @return \Buttress\ConcreteClient\Connection\ModernConnection
     */
    abstract protected function createConnection();

    /**
     * Resolve the application object from a concrete5 site
     * @param string $path
     * @return \Concrete\Core\Application\Application
     */
    private function resolveApplication($path)
    {
        chdir($path);

        // Setup
        $this->defineConstants($path);
        $this->registerAutoload($path);

        // Get the concrete5 application
        $cms = $this->getApplicationInstance($path);

        // Boot the runtime
        $this->bootApplication($cms);

        return $cms;
    }

    /**
     * @param $path
     */
    protected function defineConstants($path)
    {
        // Define some required constants
        define('DIR_BASE', $path);
        define('C5_ENVIRONMENT_ONLY', true);

        // Load in the rest of them
        require $path . '/concrete/bootstrap/configure.php';
    }

    /**
     * @param $path
     */
    protected function registerAutoload($path)
    {
        // Load in concrete5's autoloader
        require $path . '/concrete/bootstrap/autoload.php';
    }

    /**
     * @param $path
     * @return \Concrete\Core\Application\Application
     */
    protected function getApplicationInstance($path)
    {
        return require $path . '/concrete/bootstrap/start.php';
    }

    /**
     * @param $cms
     */
    protected function bootApplication(Application $cms)
    {
        if (method_exists($cms, 'getRuntime')) {
            $runtime = $cms->getRuntime();
            $runtime->boot();
        }
    }
}
