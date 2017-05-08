<?php
namespace Buttress\ConcreteClient\Adapter;

use Buttress\Concrete\Locator\Site;
use Buttress\ConcreteClient\Exception\VersionMismatchException;

class AdapterFactory
{

    /**
     * Get an adapter from a site object
     *
     * @param \Buttress\Concrete\Locator\Site $site
     * @return \Buttress\ConcreteClient\Adapter\Adapter
     * @throws \Buttress\ConcreteClient\Exception\VersionMismatchException
     */
    public function forSite(Site $site)
    {
        return $this->forVersion($site->getVersion());
    }

    /**
     * Get an adapter for a version
     *
     * @param string $version
     * @return \Buttress\ConcreteClient\Adapter\Adapter
     * @throws \Buttress\ConcreteClient\Exception\VersionMismatchException
     */
    public function forVersion($version)
    {
        if (version_compare($version, '5.6.0', '<')) {
            throw VersionMismatchException::expected('> 5.6.0', $version);
        }

        $map = [
            '5.6.9999' => Version6Adapter::class,
            '5.7.9999' => Version7Adapter::class,
            '8.9999' => Version8Adapter::class
        ];

        foreach ($map as $lessThan => $class) {
            if (version_compare($version, $lessThan, '<')) {
                return new $class;
            }
        }

        throw new VersionMismatchException('< 9.0.0', $version);
    }
}
