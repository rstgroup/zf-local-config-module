<?php


namespace RstGroup\ZfLocalConfigModule\Controller;

use Psr\Container\ContainerInterface;

/** @codeCoverageIgnore */
final class LocalConfigControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config')['rst_group']['local_config'];

        return new LocalConfigController(
            $config['filename'],
            $container->get($config['writer']),
            $container->get($config['reader'])
        );
    }
}
