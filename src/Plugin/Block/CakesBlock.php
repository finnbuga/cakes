<?php

namespace Drupal\fatbeehive_cakes\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\fatbeehive_cakes\CakesManager;

/**
 * Provides a 'CakesBlock' block.
 *
 * @Block(
 *  id = "cakes",
 *  admin_label = @Translation("Cakes"),
 * )
 */
class CakesBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\fatbeehive_cakes\CakesManager definition.
   *
   * @var \Drupal\fatbeehive_cakes\CakesManager
   */
  protected $cakesManager;

  /**
   * CakesBlock constructor.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\fatbeehive_cakes\CakesManager $cakesManager
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    CakesManager $cakesManager
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->cakesManager = $cakesManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('fatbeehive_cakes.cakes_manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#theme' => 'item_list',
      '#items' => $this->cakesManager->getAllCakesNames(),
      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }
}
