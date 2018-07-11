<?php
declare(strict_types=1);
namespace yii\i18n;

use function PHPUnit\Expect\{expect, it};
use PHPUnit\Framework\{TestCase};

/**
 * Tests the features of the `yii\i18n\YamlMessageSource` class.
 */
class YamlMessageSourceTest extends TestCase {

  /**
   * @test YamlMessageSource::flatten
   */
  public function testFlatten(): void {
    $flatten = function($array) {
      return $this->flatten($array);
    };

    it('should merge the keys of a multidimensional array', function() use ($flatten) {
      $model = new YamlMessageSource;
      expect($flatten->call($model, []))->to->equal([]);
      expect($flatten->call($model, ['foo' => 'bar', 'baz' => 'qux']))->to->equal(['foo' => 'bar', 'baz' => 'qux']);
      expect($flatten->call($model, ['foo' => ['bar' => 'baz']]))->to->equal(['foo.bar' => 'baz']);

      $source = [
        'foo' => 'bar',
        'bar' => ['baz' => 'qux'],
        'baz' => ['qux' => [
          'foo' => 'bar',
          'bar' => 'baz'
        ]]
      ];

      expect($flatten->call($model, $source))->to->equal([
        'foo' => 'bar',
        'bar.baz' => 'qux',
        'baz.qux.foo' => 'bar',
        'baz.qux.bar' => 'baz'
      ]);
    });

    it('should allow different nesting separators', function() use ($flatten) {
      $source = [
        'foo' => 'bar',
        'bar' => ['baz' => 'qux'],
        'baz' => ['qux' => [
          'foo' => 'bar',
          'bar' => 'baz'
        ]]
      ];

      $model = new YamlMessageSource(['nestingSeparator' => '/']);
      expect($flatten->call($model, $source))->to->equal([
        'foo' => 'bar',
        'bar/baz' => 'qux',
        'baz/qux/foo' => 'bar',
        'baz/qux/bar' => 'baz'
      ]);

      $model = new YamlMessageSource(['nestingSeparator' => '->']);
      expect($flatten->call($model, $source))->to->equal([
        'foo' => 'bar',
        'bar->baz' => 'qux',
        'baz->qux->foo' => 'bar',
        'baz->qux->bar' => 'baz'
      ]);
    });
  }

  /**
   * @test YamlMessageSource::getMessageFilePath
   */
  public function testGetMessageFilePath(): void {
    $getMessageFilePath = function($category, $language) {
      return $this->getMessageFilePath($category, $language);
    };

    it('should return the proper path to the message file', function() use ($getMessageFilePath) {
      $model = new YamlMessageSource(['basePath' => '@root/test/fixtures']);
      $messageFile = str_replace('/', DIRECTORY_SEPARATOR, __DIR__.'/fixtures/fr/messages.yaml');
      expect($getMessageFilePath->call($model, 'messages', 'fr'))->to->equal($messageFile);
    });

    it('should should support different file extensions', function() use ($getMessageFilePath) {
      $model = new YamlMessageSource(['basePath' => '@root/test/fixtures', 'fileExtension' => 'yml']);
      $messageFile = str_replace('/', DIRECTORY_SEPARATOR, __DIR__.'/fixtures/fr/messages');
      expect($getMessageFilePath->call($model, 'messages', 'fr'))->to->equal("$messageFile.yml");
    });
  }

  /**
   * @test YamlMessageSource::loadMessagesFromFile
   */
  public function testLoadMessagesFromFile(): void {
    $loadMessagesFromFile = function($messageFile) {
      return $this->loadMessagesFromFile($messageFile);
    };

    it('should properly load the JSON source and parse it as array', function() use ($loadMessagesFromFile) {
      $model = new YamlMessageSource(['basePath' => '@root/test/fixtures', 'enableNesting' => true]);
      $messageFile = \Yii::getAlias("{$model->basePath}/fr/messages.yaml");
      expect($loadMessagesFromFile->call($model, $messageFile))->to->equal([
        'Hello World!' => 'Bonjour le monde !',
        'foo.bar.baz' => 'FooBarBaz'
      ]);
    });

    it('should enable proper translation of source strings', function() {
      $model = new YamlMessageSource(['basePath' => '@root/test/fixtures', 'enableNesting' => true]);
      expect($model->translate('messages', 'Hello World!', 'fr'), 'Bonjour le monde !');
      expect($model->translate('messages', 'foo.bar.baz', 'fr'), 'FooBarBaz');
    });
  }

  /**
   * @test YamlMessageSource::parseMessages
   */
  public function testParseMessages(): void {
    $parseMessages = function($messageData) {
      return $this->parseMessages($messageData);
    };

    // TODO
    it('should parse a YAML file as a hierarchical array', function() use ($parseMessages) {
      $model = new YamlMessageSource(['basePath' => '@root/test/fixtures', 'enableNesting' => true]);
      $messages = $parseMessages->call($model, file_get_contents(\Yii::getAlias("{$model->basePath}/fr/messages.yaml")));
    });
  }
}