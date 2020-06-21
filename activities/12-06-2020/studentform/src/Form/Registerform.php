<?php

namespace Drupal\studentform\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Entity;
use Drupal\Core\Url;
use Drupal\Core\Database\Database;

class Registerform extends FormBase {

  /**
   * Returns a unique string identifying the form.
   *
   * The returned ID should be a unique string that can be a valid PHP function
   * name, since it's used in hook implementation names such as
   * hook_form_FORM_ID_alter().
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'register form';
  }
  
  public function buildForm(array $form, FormStateInterface $form_state) {
	
	$config = \Drupal::config('registerform.settings');
	$form['username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Username'),
      '#maxlength' => 50,
      '#required' => TRUE,
    
    ];
    
    $form['email'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Email'),
      '#maxlength' => 50,
      '#required' => TRUE,
    
    ];
	
	$form['password'] = [
      '#type' => 'password',
      '#title' => $this->t('Password'),
	  '#required' => TRUE,	  
    ];
	
    
    // Group submit handlers in an actions element with a key of "actions" so
    // that it gets styled correctly, and so that other modules may add actions
    // to the form. This is not required, but is convention.
    $form['actions'] = [
      '#type' => 'actions',
    ];

    // Add a submit button that handles the submission of the form.
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;

  }
  
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);

    $username = $form_state->getValue('username');
    $email = $form_state->getValue('email');
	$password = $form_state->getValue('password');

    if (strlen($username) < 10) {
      // Set an error for the form element with a key of "username".
      $form_state->setErrorByName('username', $this->t('The username must be at least 10 characters long.'));
    }

    if (empty($email)){
      // Set an error for the form element with a key of "accept".
      $form_state->setErrorByName('email', $this->t('Please provide email'));
    }
	
	if (empty($password)){
      // Set an error for the form element with a key of "accept".
      $form_state->setErrorByName('password', $this->t('Please provide password'));
    }

  }
  
   public function submitForm(array &$form, FormStateInterface $form_state) {
    
    //$config = \Drupal::config('formelements_example.settings')->getEditable();
    $config = \Drupal::service('config.factory')->getEditable('registerform.settings');
    $config->set('user.name', $form_state->getValue('username'));
    $config->set('user.email', $form_state->getValue('email'));
    $config->save();

    drupal_set_message($this->t("@message", ['@message' => 'Configuration Successfully Updated.']));
  }

}
