<?php

/**
 * @file
 * Contains cake.page.inc.
 *
 * Page callback for Cake entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Cake templates.
 *
 * Default template: cake.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_cake(array &$variables) {
  // Fetch Cake Entity Object.
  $cake = $variables['elements']['#cake'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
