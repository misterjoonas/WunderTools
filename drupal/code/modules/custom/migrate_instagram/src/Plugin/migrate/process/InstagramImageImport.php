<?php

/**
 * @file
 * Contains \Drupal\migrate_instagram\Plugin\migrate\process\InstagramImageImport.
 */

namespace Drupal\migrate_instagram\Plugin\migrate\process;

use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;

/**
 * Import an image during migration.
 *
 * Fetches the file, and yields a file ID.
 *
 * @MigrateProcessPlugin(
 *   id = "instagram_image_import"
 * )
 */
class InstagramImageImport extends ProcessPluginBase {
  /**
  * {@inheritdoc}
  */
  public function transform($image_url, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    if (empty($image_url)) {
      // Skip this item if there's no URL.
      throw new MigrateSkipProcessException();
    }

    // Save the file, return its ID.
    $file = system_retrieve_file($image_url, 'public://instagram/', TRUE, FILE_EXISTS_REPLACE);
    return $file->id();
  }
}
