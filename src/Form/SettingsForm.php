<?php

namespace Drupal\ridiculous_dates\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\ridiculous_dates\Helper\ValidationHelper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\ridiculous_dates\Helper\ValidationHelperInterface;

/**
 * Configure Ridiculous Dates settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  protected $logger;

  protected $validationHelper;

  /**
   * SettingsForm constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $logger
   *   The logger channel factory.
   * @param \Drupal\ridiculous_dates\Helper\ValidationHelperInterface $validation_helper
   *   The ridiculous dates validation helper.
   */
  public function __construct(ConfigFactoryInterface $config_factory, LoggerChannelFactoryInterface $logger, ValidationHelperInterface $validation_helper) {
    parent::__construct($config_factory);
    $this->logger = $logger;
    $this->validationHelper = $validation_helper;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
        $container->get('config.factory'),
        $container->get('logger.factory'),
        $container->get('validation_helper.ridiculous_dates')
      );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ridiculous_dates_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['ridiculous_dates.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['dates'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Dates'),
      '#default_value' => $this->config('ridiculous_dates.settings')->get('dates'),
      '#rows' => 10,
      '#resizable' => 'vertical',
      '#description' => $this->t('Please enter each date on a new line. Dates must match the following format, "Name of day:Y-m-d". For example: Birth of James T. Kirk:2233-03-22'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

    // Check there are no tags.
    $submittedDates = $form_state->getValue('dates');
    if (ValidationHelper::checkForHtmlMarkup($submittedDates)) {
      // Explode submitted values by new line.
      $submittedDatesExplode = explode(PHP_EOL, $submittedDates);
      // Loop through array checking for invalid submitted dates.
      foreach ($submittedDatesExplode as $submittedDate) {
        if ($this->validationHelper->checkForInvalidRidiculousDate($submittedDate)) {
          $form_state->setErrorByName(
                'dates',
                $this->t('There is a problem with the format of one/more of your submitted dates'));
          $this->logger->get('Ridiculous Dates')->warning('A user failed to amend the ridiculous dates.');
          // Break at the first fail.
          break;
        }
      }
    }
    else {
      $form_state->setErrorByName(
            'dates',
            $this->t('There is html in your submitted dates, please remove it before saving again.'));
    }

    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('ridiculous_dates.settings')
      ->set('dates', $form_state->getValue('dates'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
