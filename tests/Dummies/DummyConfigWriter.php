<?php


namespace RstGroup\ZfLocalConfigModule\Tests\Dummies;


use Zend\Config\Writer\WriterInterface;

class DummyConfigWriter implements WriterInterface
{
    private $lastWrittenConfig;

    /**
     * Write a config object to a file.
     *
     * @param  string $filename
     * @param  mixed  $config
     * @param  bool   $exclusiveLock
     * @return void
     */
    public function toFile($filename, $config, $exclusiveLock = true)
    {
        $this->lastWrittenConfig = $config;
    }

    public function getLastWrittenConfig()
    {
        return $this->lastWrittenConfig;
    }

    /**
     * Write a config object to a string.
     *
     * @param  mixed $config
     * @return string
     */
    public function toString($config)
    {
        throw new \BadMethodCallException('Not implemented.');
    }
}
