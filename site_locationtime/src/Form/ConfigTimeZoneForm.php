<?php  
/**  
 * @file  
 * Contains Drupal\site_locationtime\Form\ConfigTimeZoneForm.  
 */  
namespace Drupal\site_locationtime\Form;  
use Drupal\Core\Form\ConfigFormBase;  
use Drupal\Core\Form\FormStateInterface;  

class ConfigTimeZoneForm extends ConfigFormBase {  
    /**  
   * {@inheritdoc}  
   */  
  protected function getEditableConfigNames() {  
    return [  
      'sitelocationtime.adminsettings',  
    ];  
  }  

  /**  
   * {@inheritdoc}  
   */  
  public function getFormId() {  
    return 'sitelocationtime_form';  
  }  

  /**  
   * {@inheritdoc}  
   */  
  public function buildForm(array $form, FormStateInterface $form_state) {  
    $config = $this->config('sitelocationtime.adminsettings');  

    $form['site_country'] = [  
      '#type' => 'textfield',  
      '#title' => $this->t('Country'),  
      '#description' => $this->t('Enter the country name'),  
      '#required' => TRUE,
      '#default_value' => $config->get('site_country'),  
    ];  

    $form['site_city'] = [  
      '#type' => 'textfield',  
      '#title' => $this->t('City'),  
      '#description' => $this->t('Enter the city name'),  
      '#required' => TRUE,
      '#default_value' => $config->get('site_city'),  
    ];  

    $form['site_time_zone'] = [  
      '#type' => 'select',  
      '#title' => $this->t('Time Zone'),  
      '#description' => $this->t('Select the time zone'), 
      '#required' => TRUE, 
      '#options' => array(
        '' => t('Options in the select list'),
        'America/Chicago' => t('America/Chicago'),
        'America/New_York' => t('America/New_York'),
        'Asia/Tokyo' => t('Asia/Tokyo'),
        'Asia/Dubai' => t('Asia/Dubai'),
        'Asia/Kolkata' => t('Asia/Kolkata'),
        'Europe/Amsterdam' => t('Europe/Amsterdam'),
        'Europe/Oslo' => t('Europe/Oslo'),
        'Europe/London' => t('Europe/London'),
      ), 
      '#default_value' => $config->get('site_time_zone'),
    ];   

    return parent::buildForm($form, $form_state);  
  }  

   /**  
   * {@inheritdoc}  
   */  
  public function submitForm(array &$form, FormStateInterface $form_state) {  
    parent::submitForm($form, $form_state);  

    $this->config('sitelocationtime.adminsettings')  
      ->set('site_country', $form_state->getValue('site_country'))
      ->set('site_city', $form_state->getValue('site_city'))
      ->set('site_time_zone', $form_state->getValue('site_time_zone'))
      ->save();  
  }  


}  