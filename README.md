# ZF Local Config Module

This module allows you to dynamically adjust configuration of your application via command-line interface.

## Installation

Require module with Composer:

```bash
composer require rstgroup/zf-local-config-module
```

The next step is adding module to ZF system configuration (`config/application.config.php`):
```php
return [
    'modules' => [
        (...),
        'RstGroup\ZfLocalConfigModule',
    ],
    (...)
]
```

... and providing the required configuration in your application's config:

```php
return [
    'rst_group' => [
        'local_config' => [
            'filename' => 'config/autoload/dynamic-config.local.php'
        ],
    ],
];
```

## Usage

The module provides command-line commands to help managing local, dynamically generated, application configuration.

### Setting configuration

Setting configuration is as simple as writing the line:

```bash
php public/index.php local-config set path.to.value string-value
```

This will result in writing the code into `config/autoload/dynamic-config.local.php` file:
```php
return [
    'path' => [
        'to' => [
            'value' => 'string-value'
        ],
    ],
];
```

By default, all values passed via command line are treated as strings. To set value of any simple type, you can use JSON
notation. To enable it, just add `--json` flag. 

Look at some of the examples below:

```bash
# setting a number
php public/index.php local-config set path.to.value 1234 --json
# setting null
php public/index.php local-config set path.to.value null --json
```

JSON notation can also be used to set a structure or an array in given path:

```bash
# setting an array
php public/index.php local-config set array "[1,2,3,4]" --json
# setting complex structure
php public/index.php local-config set structure '{"complex":{"structure":{"x":"y"},"x":null}}' --json
```

The result of these two commands ran one after another would be a `config/autoload/dynamic-config.local.php` file like:

```php
return [
    'array' => [ 1, 2, 3, 4 ],
    'complex' => [
        'structure' => [
            'x' => 'y'
        ],
        'x' => null,
    ],
];
```
