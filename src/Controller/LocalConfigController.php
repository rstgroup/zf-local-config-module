<?php


namespace RstGroup\ZfLocalConfigModule\Controller;


use Zend\Config\Config;
use Zend\Config\Reader\ReaderInterface;
use Zend\Config\Writer\WriterInterface;
use Zend\Console\Request;
use Zend\Mvc\Console\Controller\AbstractConsoleController;

class LocalConfigController extends AbstractConsoleController
{
    /** @var WriterInterface */
    private $writer;
    /** @var ReaderInterface */
    private $reader;
    /** @var string */
    private $localConfigFile;

    /**
     * @param string          $localConfigFile path where to store local config
     * @param WriterInterface $writer          to store local config in file
     * @param ReaderInterface $reader          to load existing local config file
     */
    public function __construct($localConfigFile, WriterInterface $writer, ReaderInterface $reader)
    {
        if (empty($localConfigFile)) {
            throw new \RuntimeException('local-config CLI tool can not be used without local config file defined!');
        }

        $this->localConfigFile = $localConfigFile;
        $this->writer = $writer;
        $this->reader = $reader;
    }

    public function setAction()
    {
        /** @var Request $request */
        $request = $this->getRequest();

        $path   = $request->getParam('path');
        $value  = $request->getParam('value');
        $isJson = $request->getParam('json');

        if ($isJson) {
            $value = json_decode($value, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \InvalidArgumentException("Json is invalid: " . json_last_error_msg());
            }
        }

        // load config file
        $config = $this->loadConfig($this->localConfigFile);

        // update value
        $this->setToPath($config, $path, $value);

        // save config
        $this->saveConfig($config, $this->localConfigFile);
    }

    /**
     * @param Config $config
     * @param string $filename
     */
    private function saveConfig(Config $config, $filename)
    {
        $this->writer->toFile($filename, $config);
    }

    private function setToPath(Config $config, $path, $value)
    {
        $keys          = explode('.', $path);
        $lastKey       = array_pop($keys);
        $currentConfig = &$config;

        foreach ($keys as $key) {
            if (!isset($currentConfig->$key)) {
                $currentConfig->{$key} = [];
            }

            $currentConfig = &$currentConfig->{$key};
        }

        $currentConfig->{$lastKey} = $value;
    }

    /**
     * @param $filename
     * @return Config
     */
    private function loadConfig($filename)
    {
        return new Config($this->reader->fromFile($filename), true);
    }
}
