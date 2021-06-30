<?php
namespace Drupal\drupal_assignment\Services;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Datetime\DateFormatterInterface;

/**
 * Class AdminTimeZoneService
 */
class AdminTimeZoneService {

  /**
   * Drupal\Core\Config\ConfigFactoryInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Drupal\Core\Datetime\DateFormatterInterface definition.
   *
   * @var Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  function __construct(
    ConfigFactoryInterface $config_factory,
    DateFormatterInterface $date_formatter
  ) {
    $this->configFactory = $config_factory;
    $this->dateFormatter = $date_formatter;
  }

  /**
   * return formatted time for selected timezone
   *
   * @return string
   */
  public function getFormattedDateForTimezone() {
    $config = $this->configFactory->get('drupal_assignment.config_time_in_timezone');
    $time_zone = $config->get('time_zone') ? $config->get('time_zone'):'America/Chicago';

    $formatted_date = $this->dateFormatter->format(time(), 'custom', 'dS M Y - g:i a', $time_zone);

    return $formatted_date;
  }
  
  /**
   * Returns the Saved Admin config data
   *
   * @return array.
   */
  public function getAdminConfigData(){
    $config = $this->configFactory->get('drupal_assignment.config_time_in_timezone');
    $country = $config->get('country') ? $config->get('country'):'America'; 
    $city = $config->get('city') ? $config->get('city'):'Chicago';
    $time_zone = $config->get('time_zone') ? $config->get('time_zone'):'America/Chicago';

    return [
      'country' => $country,
      'city' => $city,
      'time_zone' => $time_zone
    ];
  }
}
