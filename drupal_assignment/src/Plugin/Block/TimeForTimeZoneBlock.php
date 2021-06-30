<?php

namespace Drupal\drupal_assignment\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use \Drupal\drupal_assignment\Services\AdminTimeZoneService;

/**
 * Provides a 'TimeForTimeZoneBlock' block.
 *
 * @Block(
 *  id = "time_for_time_zone_block",
 *  admin_label = @Translation("Time For Selected Timezone Block"),
 * )
 */
class TimeForTimeZoneBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\drupal_assignment\Services\AdminTimeZoneService definition.
   *
   * @var \Drupal\drupal_assignment\Services\AdminTimeZoneService
   */
  protected $adminTimeZoneService;

  /**
   * Constructs a new EventsBlock instance.
   *
   * @param array $configuration
   *   The plugin configuration, i.e. an array with configuration values keyed
   *   by configuration option name. The special key 'context' may be used to
   *   initialize the defined contexts by setting it to an array of context
   *   values keyed by context names.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\drupal_assignment\Services\AdminTimeZoneService $admin_timezone_service
   */
  public function __construct(
    array $configuration, 
    $plugin_id, 
    $plugin_definition, 
    AdminTimeZoneService $admin_timezone_service
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->adminTimeZoneService = $admin_timezone_service;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('drupal_assignment.admin_timezone_service')
    );
  }
  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];

    $admin_timezone_data = $this->adminTimeZoneService->getAdminConfigData();

    return [
      '#theme' => 'time_for_time_zone',
      '#config_data' => $admin_timezone_data,
			'#attached' => [
        'library' => [
          'drupal_assignment/timezone_management',
        ],
        'drupalSettings' => [
          'admin_timezone_data' => $admin_timezone_data
        ]
			]
		];
  }

  public function getCacheTags() {
    return Cache::mergeTags(parent::getCacheTags(), ['config:drupal_assignment.config_time_in_timezone']);
  }
}
