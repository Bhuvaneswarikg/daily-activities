<?php

namespace Drupal\customform\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\drupal_set_message;
use Drupal\user\Entity\User;
use Drupal\Core\Config\Config;
use Drupal\Core\Entity\t;
use Drupal\Core\Config\StorageInterface;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Class Configuration Setting.
 *
 * @package Drupal\customform\Form
 */
class Registerform extends FormBase {

  /**
   * {@inheritdoc}
   */
  
 
  public function buildForm(array $form, FormStateInterface $form_state) {
    
	$config = \Drupal::config('customform.settings');
	$current_user = User::load(\Drupal::currentUser()->id());
	$roles = $current_user->getRoles();
	
	if ($roles[1] == 'student') {
	
	} else {

	$user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
	$email = $user->get('mail')->value;
	$name = $user->get('name')->value;
	$uid= $user->get('uid')->value;
	
	
    $form['username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Username'),
      '#maxlength' => 30,
      '#required' => TRUE,
      '#disabled' => TRUE,
      '#default_value' => $this->t($name),
    ];
    
    $form['rollno'] = [
      '#type' => 'tel',
      '#title' => $this->t('Roll No'),
      '#maxlength' => 10,
      '#required' => TRUE,
    ];
  
	// $form['radio'] = [
     // '#type' => 'radios',
      //'#title' => $this->t('Would you like to view chapter then choose option yes'),
      //'#options' => [0 => $this->t('No'), 1 => $this->t('Yes')],
      //'#required' => TRUE,
    //];
	
	
    $form['actions']['#type'] = 'actions';

    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#button_type' => 'primary',
    );
	return $form;
	}

    
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
	  
    return 'customform';
  }
  

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    
//	$config = \Drupal::service('config.factory')->getEditable('customform.settings')->delete();
    //$config = \Drupal::config('customform.settings')->getEditable();
	 //print_r($form['name']);die;
	
	$user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
	$email = $user->get('mail')->value;
	$name = $user->get('name')->value;
	$uid= $user->get('uid')->value;
	
	$username=$form_state->getValue('username');
	$rollno=$form_state->getValue('rollno');
	//$radio=$form_state->getValue('radio');
	
	
	//if ($radio == '1') {
		// $account = \Drupal::currentUser();
			//$user = \Drupal\user\Entity\User::load($account->id());
			
			//$user->addRole('student');
			//$user->save();
			//drupal_set_message($this->t("@message", ['@message' => 'Student role has been assigned to you can view the chapters now']));
	//} elseif ($radio == '0') {
		//drupal_set_message($this->t("@message", ['@message' => 'Sorry,you have choose the option no, so you cannot view chapters']));
	//}
	
	$data=['id'=>$uid,'username'=>$name,'rollno'=>$rollno];
	//print_r($data['rollno']);die;
	$key=$data['username'];
	$config = \Drupal::service('config.factory')->getEditable('customform.settings');
    $config->set('user.name', $data['username']);
    $config->set('user.rollno', $data['rollno']);
    $config->save();
	drupal_set_message($this->t("@message", ['@message' => 'Your Details has been submitted successfully']));   
    
  }

 
}
