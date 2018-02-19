<?php

namespace Buttress\ConcreteClient;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function requireFixture($fixture)
    {
        $file = dirname(__DIR__) . '/fixtures/' . $fixture;
        if (!file_exists($file)) {
            $this->markTestSkipped(sprintf('Directory "%s" not created, run `composer prepare-fixtures`', $file));
        }

        if (is_dir($file) && file_exists($file . '/web')) {
            $file = $file . '/web';
        }

        return realpath($file);
    }

    protected function checkRequirements()
    {
        parent::checkRequirements();
        $annotations = $this->getAnnotations();
        $phpVersion = null;

        $class = isset($annotations['class']['requires']) ? $annotations['class']['requires'] : [];
        $method = isset($annotations['method']['requires']) ? $annotations['method']['requires'] : [];

        $requires = array_merge($class, $method);

        foreach ($requires as $require) {
            if (strtolower($require) === 'php7') {
                $phpVersion = 7;
                break;
            }

            if (strtolower($require) === 'php5') {
                $phpVersion = 5;
            }
        }

        if ($phpVersion === 5 && version_compare(PHP_VERSION, '7.0.0', '>=')) {
            $this->markTestSkipped('This test requires PHP5');
        }

        if ($phpVersion === 7 && !version_compare(PHP_VERSION, '7.0.0', '>=')) {
            $this->markTestSkipped('This test requires PHP7');
        }
    }
}
