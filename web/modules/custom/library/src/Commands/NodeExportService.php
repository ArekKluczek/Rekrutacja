<?php

declare(strict_types = 1);

namespace Drupal\library\Commands;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drush\Commands\DrushCommands;

/**
 * Node export service.
 */
class NodeExportService extends DrushCommands {

  use StringTranslationTrait;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected EntityTypeManagerInterface $entityTypeManager;

  /**
   * Constructs a new NodeExportService object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    parent::__construct();
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   *   Exports every node to file.
   *
   * @param string $file
   *   File input.
   *
   * @command library:export_nodes
   * @aliases ll-en
   * @usage library:export_nodes article /tmp/articles.txt
   *   Exports every node to file.
   */
  public function exportNodes(string $file): void {
    $books = $this->entityTypeManager->getStorage('book')->loadMultiple();

    $output = [];
    foreach ($books as $book) {
      $output[] = $book->id() . ' - ' . $book->getTitle();
    }

    file_put_contents($file, implode("\n", $output));
    $this->logger()->success(dt('Node IDs and titles have been exported to @file.', ['@file' => $file]));
  }

}
