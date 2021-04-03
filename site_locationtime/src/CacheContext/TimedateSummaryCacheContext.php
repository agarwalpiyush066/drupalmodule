<?php

namespace Drupal\site_locationtime\CacheContext;

use Drupal\Core\Cache\Context\CacheContextInterface;
use Drupal\Core\Session\AccountProxy;
use Drupal\user\Entity\User;
use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Datetime\DateFormatter;
use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Config\ConfigFactoryInterface;

class TimedateSummaryCacheContext implements CacheContextInterface {

  /**
  * {@inheritdoc}
  */

  /**
  * The Date Fromatter.
  * The Drupal Config Factory service.
  *
  * @var \Drupal\Core\Datetime\DateFormatter
  * @var \Drupal\Core\Config\ConfigFactoryInterface
  */

  protected $date_formatter;
  protected $configFactoryService;
	public function __construct(DateFormatter $date_formatter, ConfigFactoryInterface $configFactoryService) {
    $this->date_formatter = $date_formatter;
    $this->configFactoryService = $configFactoryService;
	}

  /**
  * {@inheritdoc}
  */
	public static function getLabel() {
		return t('Location and Date TIme Summary cache context');
	}

  /**
  * {@inheritdoc}
  */
	public function getContext() {
        $config = $this->configFactoryService->get('sitelocationtime.adminsettings');
        $request_time = \Drupal::time()->getCurrentTime();
        $summary = $this->date_formatter->format( $request_time, 'custom', 'jS M Y - g:i A', $config->get('site_time_zone'));
        return $summary;
    }

  /**
  * {@inheritdoc}
  */
  public function getCacheableMetadata() {
    return new CacheableMetadata();
  }
}