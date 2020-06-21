<?php

namespace Drupal\form_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\drupal_set_message;

/**
 * Class Configuration Setting.
 *
 * @package Drupal\form_module\Form
 */
class AddDetails extends FormBase {

 

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
	
	$uid = \Drupal::currentUser()->id();
	$uname = \Drupal::currentUser()->getUsername();
	
	$users = \Drupal::entityTypeManager()->getStorage('user')->loadByProperties(['uid' => $uid]);
	

	$user = reset($users);
	
	if ($user) {
	  $uid = $user->id();
	  $rids = $user->getRoles();
	}
	
	
    $form['username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Username'),
      '#maxlength' => 30,
      '#required' => TRUE,
      '#disabled' => TRUE,
      '#default_value' => $this->t($uname),
    ];
    
    $form['rollno'] = [
      '#type' => 'tel',
      '#title' => $this->t('Roll No'),
      '#maxlength' => 10,
      '#required' => TRUE,
    ];
  

    $form['actions']['#type'] = 'actions';

    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Request'),
      '#button_type' => 'primary',
    );
	

    return $form;
  }
   
     /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // valiodate form values
    if ($form_state->getValue('rollno') == '') {
      $msg = t('<strong>Roll No is required!</strong>');
      $form_state->setErrorByName('form', $msg);
    }
  }
  
  public function getFormId() {
    return 'form_module';
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    
    //$config = \Drupal::config('form_module.settings')->getEditable();
	// print_r($form['name']);die;
	
	$uid = \Drupal::currentUser()->id();
	$uname = \Drupal::currentUser()->getUsername();
	
	$username=$form_state->getValue('username');
	$rollno=$form_state->getValue('rollno');
	
	$data=['id'=>$uid,'username'=>$uname,'rollno'=>$rollno,'assign_status'=>0];
	// print_r($data);die;
	
    $config = \Drupal::service('form_module.add')->store($data);
   
    drupal_set_message($this->t("@message", ['@message' => 'Request Sent Successfully.']));
  }

 
}
