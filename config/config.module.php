<?php

return [
    'rst_group'       => [
        'local_config'    => [
            'filename' => null,
            'writer'   => 'RstGroup\\ZfExternalConfigModule\\LocalConfigWriter',
            'reader'   => 'RstGroup\\ZfExternalConfigModule\\LocalConfigReader',
        ],
    ],
    'controllers' => [
        'factories' => [
            \RstGroup\ZfLocalConfigModule\Controller\LocalConfigController::class => \RstGroup\ZfLocalConfigModule\Controller\LocalConfigControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            \Zend\Config\Writer\PhpArray::class                            => \Zend\ServiceManager\Factory\InvokableFactory::class,
            \RstGroup\ZfLocalConfigModule\LocalConfig\PhpFileReader::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
        ],
        'aliases'   => [
            'RstGroup\\ZfExternalConfigModule\\LocalConfigWriter' => \Zend\Config\Writer\PhpArray::class,
            'RstGroup\\ZfExternalConfigModule\\LocalConfigReader' => \RstGroup\ZfLocalConfigModule\LocalConfig\PhpFileReader::class,
        ],
    ],
    'console'         => [
        'router' => [
            'routes' => [
                'local-config-set'   => [
                    'options' => [
                        'route'    => 'local-config set <path> <value> [--json]',
                        'defaults' => [
                            'controller' => \RstGroup\ZfLocalConfigModule\Controller\LocalConfigController::class,
                            'action'     => 'set',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
