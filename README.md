# Backdrop conventions

This tool will check your code against Backdrop's coding standard.

It's based on [GrumPHP](https://github.com/phpro/grumphp) and comes with a default configuration tailored for Backdrop development.

The following checks are triggered:
* [Backdrop coder](https://packagist.org/packages/backdrop/coder) code sniffer's checks
* Custom [PHP CS Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) configuration
* PHPLint
* YAMLlint
* JSONlint

## Installation

```shell
composer require drupol/backdrop-conventions --dev
```

### If you're not using GrumPHP

Manually add to your `composer.json` file:

```yaml
    "extra": {
        "grumphp": {
            "config-default-path": "vendor/drupol/backdrop-conventions/config/backdrop/grumphp.yml"
        }
    }
```

### If you're using GrumPHP already

Edit the file `grumphp.yml.dist` or `grumphp.yml` and add on the top it:

```yaml
imports:
  - { resource: vendor/drupol/backdrop-conventions/config/backdrop/grumphp.yml }
```

To add an extra Grumphp task:

```yaml
imports:
  - { resource: vendor/drupol/backdrop-conventions/config/backdrop7/grumphp.yml }

parameters:
  extensions:
    - drupol\BackdropConventions\GrumphpTasksExtension
  extra_tasks:
    phpunit:
      always_execute: false
```

In conjunction with `extra_tasks`, use `skip_tasks` to exclude default tasks if needed.

## Usage

`./vendor/bin/grumphp run`

## Contributing

Feel free to contribute to this library by sending Github pull requests. I'm quite reactive :-)
