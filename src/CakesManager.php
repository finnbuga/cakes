<?php

namespace Drupal\fatbeehive_cakes;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityManager;
use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\user\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CakesManager.
 *
 * @package Drupal\fatbeehive_cakes
 */
class CakesManager extends ControllerBase {

  /**
   * @var \Drupal\Core\Entity\EntityManager
   */
  protected $entityManager;

  /**
   * @var \Drupal\Core\Entity\Query\QueryFactory
   */
  protected $entityQuery;

  /**
   * CakesManager constructor.
   *
   * @param \Drupal\Core\Entity\EntityManager $entity_manager
   * @param \Drupal\Core\Entity\Query\QueryFactory $entity_query
   */
  public function __construct(EntityManager $entity_manager, QueryFactory $entity_query) {
    $this->entityManager = $entity_manager;
    $this->entityQuery = $entity_query;
  }

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *
   * @return static
   */
  public static function create(ContainerInterface $container) {
    return new static (
      $container->get('entity.manager'),
      $container->get('entity.query')
    );
  }

  /**
   * Create three cakes if none present
   */
  public function createCakesIfNone() {
    $cakesExist = $this->entityQuery->get('cake')
      ->condition('status', 1)
      ->range(0, 1)
      ->count()
      ->execute();

    if (!$cakesExist) {
      for ($i = 1; $i <= 3; $i++) {
        $this->createCake('Cake ' . $i);
      }
    }
  }

  /**
   * Get all cakes names
   *
   * @return array
   */
  public function getAllCakesNames() {
    /**
     * @var \Drupal\fatbeehive_cakes\Entity\Cake[]
     */
    $cakes = \Drupal::entityTypeManager()->getStorage('cake')->loadByProperties(['status' => 1]);
    $cakesNames = [];
    foreach ($cakes as $cake) {
      $cakesNames[] = $cake->getName();
    }
    return $cakesNames;
  }

  /**
   * Create a cake with the user name if an old member
   *
   * @param \Drupal\user\Entity\User $user
   */
  public function createCakeForOldMember(User $user) {
    if ($this->isOldMember($user) && !$this->doesCakeExist($user->getUsername())) {
      $this->createCake($user->getUsername());
    }
  }

  /**
   * Create cake with name $name
   *
   * @param string $name
   */
  private function createCake(string $name) {
    $data = [
      'type' => 'cake',
      'name' => $name,
      'uid' => 1,
    ];
    $cake = $this->entityManager
      ->getStorage('cake')
      ->create($data);
    $cake->save();
  }

  /**
   * Check if user is old member
   *
   * @param \Drupal\user\Entity\User $user
   *
   * @return bool
   */
  private function isOldMember(User $user) {
    return $user->getCreatedTime() < strtotime('-7 days');
  }

  /**
   * Check if there's a cake with the give name
   *
   * @param string $name
   *
   * @return bool
   */
  private function doesCakeExist(string $name) {
    return $this->entityQuery->get('cake')
      ->condition('name', $name)
      ->range(0, 1)
      ->count()
      ->execute();
  }
}
