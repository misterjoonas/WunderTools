<?php
/**
 * @file
 * Contains Drupal\migrate_instagram\Plugin\migrate\InstagramJSONReader.
 */
namespace Drupal\migrate_instagram\Plugin\migrate;
use Drupal\migrate_source_json\Plugin\migrate\JSONReader;
use Drupal\devel;
/**
 * Object to retrieve and iterate over Instagram JSON data.
 */
class InstagramJSONReader extends JSONReader {
  /**
   * {@inheritdoc}
   */
  public function getSourceFields($url) {
    $items = parent::getSourceFields($url);
    foreach ($items as &$item) {
      // We need to dig into items array and make sure the mapped field values
      // appear on the root level of each $item for the migrate processing part
      if (isset($item['caption']) && is_array($item['caption'])) {
        if (isset($item['caption']['text'])) {
          $item['text'] = $item['caption']['text'];
        }
      }
      if (isset($item['likes']) && is_array($item['likes'])) {
        if (isset($item['likes']['count'])) {
          $item['count'] = $item['likes']['count'];
        }
      }
      if (isset($item['user']) && is_array($item['user'])) {
        if (isset($item['user']['username'])) {
          $item['username'] = $item['user']['username'];
        }
      }
      if (isset($item['images']) && is_array($item['images'])) {
        if (isset($item['images']['standard_resolution']) && is_array($item['images']['standard_resolution'])) {
          if (isset($item['images']['standard_resolution']['url'])) {
            $item['uri'] = $item['images']['standard_resolution']['url'];
            $filename = array_shift(explode('?' ,basename($item['images']['standard_resolution']['url'])));
            $item['filename'] = $filename;
            $item['filename_with_path'] = 'public://instagram/' . $filename;
          }
        }
      }
    }

    return $items;
  }
}
