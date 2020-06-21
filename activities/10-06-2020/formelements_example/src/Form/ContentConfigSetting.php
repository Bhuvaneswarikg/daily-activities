<?php

namespace Drupal\formelements_example\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Form\drupal_set_message;
use Drupal\Core\Entity\t;


/**
 * Class Configuration Setting.
 *
 * @package Drupal\formelements_example\Form
 */
class ContentConfigSetting extends FormBase {

  /**
   * {@inheritdoc}
   */
  // public static function create(ContainerInterface $container) {
  //   return new static(
  //       $container->get('formelements_example.settings')
  //   );
  // }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // valiodate form values
    if ($form_state->getValue('username') == '' || $form_state->getValue('email') == '') {
      $msg = t('<strong>Username and Email both are required!</strong>');
      $form_state->setErrorByName('form', $msg);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
    $config = \Drupal::config('formelements_example.settings');
    //echo '<pre>';print_r($config);die();
    $form['username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Username'),
      '#maxlength' => 50,
      '#required' => TRUE,
      '#default_value' => $config->get('user.name') ? $config->get('user.name') : '',
    ];
    
    $form['email'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Email'),
      '#maxlength' => 50,
      '#required' => TRUE,
      '#default_value' => $config->get('user.email') ? $config->get('user.email') : '',
    ];
	
	
	$form['actions']['preview'] = array(
  '#type' => 'button',
  '#title' => $this->t('Button'),
  '#value' => $this
    ->t('Preview'),
);

$form['copy'] = array(
  '#type' => 'checkbox',
  '#title' => $this
    ->t('Checkbox'),
);

$form['high_school']['tests_taken'] = array(
  '#type' => 'checkboxes',
  '#options' => array('SAT' => $this->t('SAT'), 'ACT' => $this->t('ACT')),
  '#title' => $this->t('What standardized tests did you take?'),
);

$form['color'] = array(
  '#type' => 'color',
  '#title' => $this
    ->t('Color'),
  '#default_value' => '#ffffff',
);

$form['needs_accommodation'] = array(
  '#type' => 'checkbox',
  '#title' => $this
    ->t('Need Special Accommodations?'),
);
$form['accommodation'] = array(
  '#type' => 'container',
  '#attributes' => array(
    'class' => 'accommodation',
  ),
  '#states' => array(
    'invisible' => array(
      'input[name="needs_accommodation"]' => array(
        'checked' => FALSE,
      ),
    ),
  ),
);
$form['accommodation']['diet'] = array(
  '#type' => 'textfield',
  '#title' => $this
    ->t('Dietary Restrictions'),
);

$form['expiration'] = array(
  '#type' => 'date',
  '#title' => $this
    ->t('Content expiration'),
  '#default_value' => array(
    'year' => 2020,
    'month' => 2,
    'day' => 15,
  ),
);

$form['author'] = array(
  '#type' => 'details',
  '#title' => $this
    ->t('Author'),
);
$form['author']['name'] = array(
  '#type' => 'textfield',
  '#title' => $this
    ->t('Name'),
);

$form['author'] = array(
  '#type' => 'fieldset',
  '#title' => $this
    ->t('Author'),
);
$form['author']['name'] = array(
  '#type' => 'textfield',
  '#title' => $this
    ->t('Name'),
);

$form['hello'] = [
  '#type' => 'html_tag',
  '#tag' => 'p',
  '#value' => $this
    ->t('Hello World'),
];

$form['hello'] = [
  '#type' => 'inline_template',
  '#template' => "{% trans %} Hello {% endtrans %} <strong>{{name}}</strong>",
  '#context' => [
    'name' => $name,
  ],
];

$form['search'] = array(
  '#type' => 'search',
  '#title' => $this
    ->t('Search'),
);
$form['status_messages'] = [
  '#type' => 'status_messages',
];

$form['text'] = array(
  '#type' => 'textarea',
  '#title' => $this
    ->t('Text'),
);

$form['title'] = array(
  '#type' => 'textfield',
  '#title' => $this
    ->t('Subject'),
  '#default_value' => $node->title,
  '#size' => 60,
  '#maxlength' => 128,
  '#required' => TRUE,
);

$form['homepage'] = array(
  '#type' => 'url',
  '#title' => $this->t('Home Page'),
  '#size' => 30,
);

$form['information'] = array(
  '#type' => 'vertical_tabs',
  '#default_tab' => 'edit-publication',
);
$form['author'] = array(
  '#type' => 'details',
  '#title' => $this
    ->t('Author'),
  '#group' => 'information',
);
$form['author']['name'] = array(
  '#type' => 'textfield',
  '#title' => $this
    ->t('Name'),
);
$form['publication'] = array(
  '#type' => 'details',
  '#title' => $this
    ->t('Publication'),
  '#group' => 'information',
);
$form['publication']['publisher'] = array(
  '#type' => 'textfield',
  '#title' => $this
    ->t('Publisher'),
);

$form['weight'] = array(
  '#type' => 'weight',
  '#title' => $this
    ->t('Weight'),
  '#default_value' => $edit['weight'],
  '#delta' => 10,
);

    $form['phone'] = [
      '#type' => 'tel',
      '#title' => $this->t('Phone'),      
    ];

    $form['actions']['#type'] = 'actions';

    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'formelements_example';
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    
    //$config = \Drupal::config('formelements_example.settings')->getEditable();
    $config = \Drupal::service('config.factory')->getEditable('formelements_example.settings');
    $config->set('user.name', $form_state->getValue('username'));
    $config->set('user.email', $form_state->getValue('email'));
    $config->save();

    drupal_set_message($this->t("@message", ['@message' => 'Configuration Successfully Updated.']));
  }

  // /**
  //  * {@inheritdoc}
  //  */
  // protected function getEditableConfigNames() {
  //   return ['formelements_example.settings'];
  // }

}
