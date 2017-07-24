<?php

namespace Drupal\fatbeehive_cakes;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Cake entity.
 *
 * @see \Drupal\fatbeehive_cakes\Entity\Cake.
 */
class CakeAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\fatbeehive_cakes\Entity\CakeInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished cake entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published cake entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit cake entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete cake entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add cake entities');
  }

}
