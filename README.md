# Gie SecureImage Bundle
This bundle is developed by Sirpa Gendarmerie. 
It's a Symfony connector to https://github.com/dapphp/securimage  [![phpcaptcha](https://www.phpcaptcha.org/logos/securimage-80x15.png)](https://www.phpcaptcha.org) project.


[![GitHub license](https://img.shields.io/github/license/jlchassaing/giecapcha?style=flat-square)](https://github.com/jlchassaing/giecapcha/blob/master/LICENSE)


## Installation

Install via composer :

```bash
composer require gie/captcha
```

add in bundles.php

```php
    Gie\SecureImage\GieSecureImageBundle::class => ['all' => true],
```

add in routes.yaml

```yaml
_gieSecureImageBundle:
  resource: '@GieSecureImageBundle/Resources/config/routes.yaml'
```

## Configuration

add a gie_secure_image.yaml file in config/packages

multiple parameters are available