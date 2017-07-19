<?php


namespace RstGroup\ZfLocalConfigModule\LocalConfig;


use Zend\Config\Reader\ReaderInterface;

final class PhpFileReader implements ReaderInterface
{
    /**
     * Read from a file and create an array
     *
     * @param  string $filename
     * @return array
     */
    public function fromFile($filename)
    {
        if (file_exists($filename)) {
            return include $filename;
        } else {
            return [];
        }
    }

    /**
     * Read from a string and create an array
     *
     * @param  string $string
     * @return array|bool
     */
    public function fromString($string)
    {
        throw new \BadMethodCallException('This reader supports fromFile() method only.');
    }
}
