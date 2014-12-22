# PHP Simple Cache

PHP class to cache dynamic pages in file and reduce Database overload

## Install

Install via [composer](https://getcomposer.org):

```javascript
{
    "require": {
        "rodrigoalviani/php-simple-cache": "~0.1"
    }
}
```

Run `composer install` then use as normal:

```php
require 'vendor/autoload.php';
$cache = new Rodrigoalviani\Cache\Cache($label);
```

## Usage

A very basic usage example:

```php
$cache = new Rodrigoalviani\Cache\Cache($_SERVER['REQUEST_URI']);
$cache->cacheInit();

// your page here

$cache->cacheEnd();
```

A more advanced example:

```php
$cache = new Rodrigoalviani\Cache\Cache($_SERVER['REQUEST_URI']);
$cache->set_filePath('tmp/');
$cache->set_cacheMaxAge(84600);
$cache->set_cacheExtension('.tmp');
$cache->cacheInit();

// your page here

$cache->cacheEnd();
```

## Credits

PHP Simple Cache was created by [Rodrigo Alviani](http://github.com/rodrigoalviani). Released under the MIT license.