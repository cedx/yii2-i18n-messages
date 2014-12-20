# JSON-Messages.yii
[![Version](http://img.shields.io/packagist/v/cedx/json-messages-yii.svg?style=flat)](https://packagist.org/packages/cedx/json-messages-yii) [![Downloads](http://img.shields.io/packagist/dt/cedx/json-messages-yii.svg?style=flat)](https://packagist.org/packages/cedx/json-messages-yii) [![License](http://img.shields.io/packagist/l/cedx/json-messages-yii.svg?style=flat)](https://github.com/cedx/json-messages.yii/blob/master/LICENSE.txt)

[JSON](http://json.org) message source for [Yii](http://www.yiiframework.com), high-performance [PHP](https://php.net) framework.

This package provides a single class, `CJsonMessageSource` which is a message source that stores translated messages in JSON files. It extends from [`CPhpMessageSource`](http://www.yiiframework.com/doc/api/1.1/CPhpMessageSource) class, so its usage is basically the same.

Within a JSON file, an object literal of (source, translation) pairs is defined. For example:

```json
{
  "original message 1": "translated message 1",
  "original message 2": "translated message 2"
}
```

## Documentation
- [API Reference](http://dev.belin.io/json-messages.yii/api)

## Installing via [Composer](https://getcomposer.org)

#### 1. Depend on it
Add this to your project's `composer.json` file:

```json
{
  "require": {
    "cedx/json-messages-yii": "*"
  }
}
```

#### 2. Install it
From the command line, run:

```shell
$ php composer.phar install
```

#### 3. Import it
Now in your application configuration file, you can use the following log route:

```php
return [
  'components' => [
    'messages' => [
      'class' => 'ext.cedx.json-messages-yii.lib.CJsonMessageSource'
    ]
  ]
];
```

Adjust the values as needed. Here, it's supposed that [`CApplication->extensionPath`](http://www.yiiframework.com/doc/api/1.1/CApplication#extensionPath-detail), that is the [`ext`](http://www.yiiframework.com/doc/guide/1.1/en/basics.namespace) root alias, has been set to Composer's `vendor` directory.

## License
[JSON-Messages.yii](https://packagist.org/packages/cedx/json-messages-yii) is distributed under the MIT License.