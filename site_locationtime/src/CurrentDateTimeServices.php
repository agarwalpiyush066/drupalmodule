<?php

/**
* @file providing the service that return current date and time on the basis of timezone.
*
*/

namespace  Drupal\site_locationtime;

use Drupal\Core\Cache\Cache;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Datetime\DateFormatter;
use Drupal\Core\PageCache\ResponsePolicy\KillSwitch;

class CurrentDateTimeServices {

  /**
  * The kill switch.
  * The Date Fromatter.
  *
  * @var \Drupal\Core\PageCache\ResponsePolicy\KillSwitch
  * @var \Drupal\Core\Datetime\DateFormatter
  */

  protected $killSwitch;
  protected $date_formatter;
  protected $say_something;

  public function __construct(KillSwitch $killSwitch, DateFormatter $date_formatter) {
    $this->killSwitch = $killSwitch;
    $this->killSwitch->trigger();
    $this->date_formatter = $date_formatter;
    $this->say_something = 'Please provide a valid timezone';
  }

  public function getCurrentTimeDate($timezone = ''){
    if (empty($timezone)) {
      return $this->say_something;
    }
    else {
      $request_time = \Drupal::time()->getCurrentTime();
      $formatted = $this->date_formatter->format( $request_time, 'custom', 'jS M Y - g:i A', $timezone);
      return [
        '#markup' => $formatted
      ];
    }
  }

}

?>