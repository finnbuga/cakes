<?php

namespace Drupal\fatbeehive_cakes\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Cake entities.
 *
 * @ingroup fatbeehive_cakes
 */
interface CakeInterface extends  ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Cake name.
   *
   * @return string
   *   Name of the Cake.
   */
  public function getName();

  /**
   * Sets the Cake name.
   *
   * @param string $name
   *   The Cake name.
   *
   * @return \Drupal\fatbeehive_cakes\Entity\CakeInterface
   *   The called Cake entity.
   */
  public function setName($name);

  /**
   * Gets the Cake creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Cake.
   */
  public function getCreatedTime();

  /**
   * Sets the Cake creation timestamp.
   *
   * @param int $timestamp
   *   The Cake creation timestamp.
   *
   * @return \Drupal\fatbeehive_cakes\Entity\CakeInterface
   *   The called Cake entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Cake published status indicator.
   *
   * Unpublished Cake are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Cake is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Cake.
   *
   * @param bool $published
   *   TRUE to set this Cake to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\fatbeehive_cakes\Entity\CakeInterface
   *   The called Cake entity.
   */
  public function setPublished($published);

}
