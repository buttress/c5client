<?php

namespace Buttress\ConcreteClient\Adapter;

use Buttress\ConcreteClient\TestCase;

class AdapterFactoryTest extends TestCase
{
    public function testCreatesFromSite()
    {
        require_once $this->requireFixture('adapter/Site.php');
        $factory = new AdapterFactory();

        $site = new \Buttress\Concrete\Locator\Site();

        $site->version = '5.6.1.2';
        $this->assertInstanceOf(Version6Adapter::class, $factory->forSite($site));

        $site->version = '5.7.5.13';
        $this->assertInstanceOf(Version7Adapter::class, $factory->forSite($site));

        $site->version = '8.1.0';
        $this->assertInstanceOf(Version8Adapter::class, $factory->forSite($site));
    }

    public function testCreatesFromRaw()
    {
        $factory = new AdapterFactory();

        $version = '5.6.1.2';
        $this->assertInstanceOf(Version6Adapter::class, $factory->forVersion($version));

        $version = '5.7.5.13';
        $this->assertInstanceOf(Version7Adapter::class, $factory->forVersion($version));

        $version = '8.1.0';
        $this->assertInstanceOf(Version8Adapter::class, $factory->forVersion($version));
    }

    /**
     * @expectedException \Buttress\ConcreteClient\Exception\VersionMismatchException
     * @expectedExceptionMessageRegExp ~got "5.4.2.2~
     */
    public function testFailsGracefully()
    {
        $factory = new AdapterFactory();
        $factory->forVersion('5.4.2.2');
    }
}
