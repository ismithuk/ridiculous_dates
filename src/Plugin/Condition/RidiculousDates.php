<?php

namespace Drupal\ridiculous_dates\Plugin\Condition;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Condition\ConditionPluginBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\ridiculous_dates\Helper\FormatHelper;

/**
 * Provides a 'Ridiculous Dates' condition.
 *
 * @Condition(
 *   id = "ridiculous_dates_ridiculous_dates",
 *   label = @Translation("Ridiculous Dates")
 * )
 *
 * @DCG prior to Drupal 8.7 the 'context_definitions' key was called 'context'.
 */
class RidiculousDates extends ConditionPluginBase implements ContainerFactoryPluginInterface {

  /**
   * Config Factory Service.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $moduleConfig;

  /**
   * Format Helper Service.
   *
   * @var \Drupal\Core\Form\FormStateInterface
   */
  protected $formatHelper;

  /**
   * The time service.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $time;

  /**
   * RidiculousDates constructor.
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
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param \Drupal\Component\Datetime\TimeInterface $time
   *   The time service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $config_factory, TimeInterface $time) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->moduleConfig = $config_factory;
    $this->time = $time;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
          $configuration,
          $plugin_id,
          $plugin_definition,
          $container->get('config.factory'),
          $container->get('datetime.time')
      );
  }

  /**
   * {@inheritdoc}
   *
   * @todo Users should be able to select multiple dates
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {

    $ridiculousDatesOptions = $this->moduleConfig->get('ridiculous_dates.settings')->get('dates');

    $formOptionArray = FormatHelper::dateStringToArray($ridiculousDatesOptions);

    $form['date'] = [
      '#type' => 'select',
      '#title' => $this->t('Select a date'),
      '#default_value' => $this->configuration['date'],
      '#options' => $formOptionArray,
      '#description' => $this->t('Please select the ridiculous date to show or NOT show your block on.'),
    ];
    return parent::buildConfigurationForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'date' => [],
    ] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    print $this->configuration['date'];
    $this->configuration['date'] = $form_state->getValue('date');
    parent::submitConfigurationForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function evaluate() {
    if ($this->configuration['date'] === 'none') {
      return TRUE;
    }
    if ($this->configuration['date'] === date("Y-m-d", $this->time->getCurrentTime())) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function summary() {
    return $this->t('Selected date is: @date',
          ['@date' => date("Y-m-d")]);
  }

}
