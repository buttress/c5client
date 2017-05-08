<?php
namespace Buttress\ConcreteClient\Adapter;

use Buttress\ConcreteClient\Connection\LegacyConnection;
use Buttress\ConcreteClient\Exception\RuntimeException;
use Buttress\ConcreteClient\Exception\VersionMismatchException;
use Buttress\ConcreteClient\Transaction\SilentTransaction;
use Buttress\ConcreteClient\Transaction\SimpleTransaction;

/**
 * An adapter that connects to legacy concrete5 sites
 * @todo Determine the lowest version of c5 we support
 */
class Version6Adapter implements Adapter
{

    /**
     * Attach to legacy concrete5
     * @throws \Buttress\ConcreteClient\Exception\VersionMismatchException
     * @throws \Buttress\ConcreteClient\Exception\RuntimeException
     */
    public function attach($path)
    {
        // If the PHP version is more than 5.6.999, we have the wrong version.
        if (version_compare(PHP_VERSION, '5.6.999', '>')) {
            throw VersionMismatchException::expected('PHP < 7.0.0', PHP_VERSION);
        }

        // Check if headers are sent
        if (headers_sent()) {
            throw new RuntimeException('Loading version 6 after headers are sent is not supported.');
        }

        // Check if we've installed
        if (!file_exists($path . '/config/site.php')) {
            throw new RuntimeException('Connecting to version 6 before installing is not supported.');
        }

        // Create a new silent transaction to handle connecting to concrete5
        return SilentTransaction::transact(function () use ($path) {
            return $this->handleAttaching($path);
        });
    }

    protected function handleAttaching($path)
    {
        // Change the cwd to the site path
        chdir($path);

        // Define a couple things concrete5 expects
        define('DIR_BASE', $path);
        define('C5_ENVIRONMENT_ONLY', true);

        // Set the error reporting low
        error_reporting(E_ALL | ~E_NOTICE | ~E_WARNING | ~E_STRICT);

        // Add 3rdparty to include path
        set_include_path(get_include_path() . PATH_SEPARATOR . $path . '/concrete/libraries/3rdparty');

        // Include Adodb first, not sure why this was needed
        require_once $path . '/concrete/libraries/3rdparty/adodb/adodb.inc.php';

        // Load in legacy dispatcher
        require_once $path . '/concrete/dispatcher.php';

        // Adodb Stuff
        $GLOBALS['ADODB_ASSOC_CASE'] = 2;
        $GLOBALS['ADODB_ACTIVE_CACHESECS'] = 300;
        $GLOBALS['ADODB_CACHE_DIR'] = defined('DIR_FILES_CACHE_DB') ? DIR_FILES_CACHE_DB : '';

        return new LegacyConnection();
    }
}
