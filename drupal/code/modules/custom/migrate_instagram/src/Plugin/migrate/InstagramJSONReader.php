<?php
/**
 * @file
 * Contains Drupal\migrate_instagram\Plugin\migrate\InstagramJSONReader.
 */
namespace Drupal\migrate_instagram\Plugin\migrate;
use Drupal\migrate_source_json\Plugin\migrate\JSONReader;
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

      debug($item, 'Item');

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
    }

    return $items;

    /*// Loop over the JSON values, walk the tree and extract as keyed values.
    foreach ($items as &$item) {
      if (isset($item['address_components']) && is_array($item['address_components'])) {
        foreach ($item['address_components'] as $component) {
          if (isset($component['long_name']) && isset($component['types']) && is_array($component['types'])) {
            foreach ($component['types'] as $type) {
              $item[$type] = $component['long_name'];
            }
          }
        }
      }
      if (isset($item['geometry']['location']['lat'])) {
        $item['lat'] = $item['geometry']['location']['lat'];
      }
      if (isset($item['geometry']['location']['lng'])) {
        $item['lng'] = $item['geometry']['location']['lng'];
      }
    }
    return $items;*/
  }
}
