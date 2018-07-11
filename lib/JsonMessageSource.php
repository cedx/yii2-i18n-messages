<?php
declare(strict_types=1);
namespace yii\i18n;

use yii\helpers\{Json};

/**
 * Represents a message source that stores translated messages in JSON files.
 */
class JsonMessageSource extends HierarchicalMessageSource {

  /**
   * @var string TODO !!! description
   */
  public $fileExtension = 'json';

  /**
   * TODO
   * @param string $messageData
   * @return array
   */
  protected function parseMessages(string $messageData): array {
    return is_array($messages = Json::decode($messageData)) ? $messages : [];
  }
}
