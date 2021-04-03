<?php

namespace Drupal\site_locationtime\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\user\Entity\User;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\site_locationtime\CurrentDateTimeServices;
/**
 * Provides a 'SiteLocationTime' block.
 *
 * @Block(
 *  id = "site_locationtime_block",
 *  admin_label = @Translation("Site Location Time Block"),
 * )
 */
class SiteLocationTImeBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var \Drupal\site_locationtime\CurrentDateTimeServices
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $sitelocationtime;
  protected $configFactory;
  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   *
   * @return static
   */

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('site_locationtime.getCurrentTimeDate'),
      $container->get('config.factory')
    );
  }

  /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\site_locationtime\CurrentDateTimeServices $currentdatetimeservice
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactoryService
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, CurrentDateTimeServices $currentdatetimeservice, ConfigFactoryInterface $configFactoryService) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->sitelocationtime = $currentdatetimeservice;
    $this->configFactory = $configFactoryService;
  }

  public function build() {
    $build = [];
    $config = $this->configFactory->get('sitelocationtime.adminsettings');
    $data = [];
    $site_country = $config->get('site_country');
    $site_city = $config->get('site_city');
    $site_time_zone = $config->get('site_time_zone');
    $placeholder = 'site_locationtime' . crc32('lazy site_locationtime block');
    $site_current_time = $this->sitelocationtime->getCurrentTimeDate($site_time_zone);
    
    $build['timedate_summary'] = [
			'#theme' => 'site_locationtime_block',
      '#variables' => Null,
      '#site_country' => $site_country,
      '#site_city' => $site_city,
      '#site_time_zone' => $site_time_zone,
      '#site_current_timedate' => $site_current_time,
		]; 
		return $build;
  }

    /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
  	return Cache::mergeContexts(
  		parent::getCacheContexts(),
  		['timedate_summary']
  	);
  }

  
}