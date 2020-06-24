<?php

namespace Drupal\viewstudentdetails\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\drupal_set_message;
use Drupal\user\Entity\User;
use Drupal\Core\Url;
/**
 * Class Configuration Setting.
 *
 * @package Drupal\form_module\Form
 */
class ViewDetails extends FormBase {


public $configid;
  /**
   * {@inheritdoc}
   */
   

  public function buildForm(array $form, FormStateInterface $form_state, $configid=NULL) {
    //echo "here"; exit;
	
 
	
	$ids = \Drupal::entityQuery('user')->condition('roles',NULL ,'IS NULL')->execute();
	$users = User::loadMultiple($ids);
	
	foreach($users as $user){
		$username = $user->get('name')->value;
		$uid = $user->get('uid')->value;
		$userlist[$uid] = $username;
	}
	
	
    


	$form['select_multiple'] = [
      '#type' => 'select',
      '#title' => 'Select (multiple)',
      '#multiple' => TRUE,
      '#options' => [
        'sat' => $userlist,        
      ],    
      
    ];
	
    $form['username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Users'),
	  '#value' => $userlist,
    ];
	
	$form['actions']['#type'] = 'actions';
	$form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#button_type' => 'primary',
    );

    return $form;
  }

     /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // valiodate form values
    
  }
  
  public function getFormId() {
    return 'viewstudentdetails';
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {   
	
	$mul_users=$form_state->getValue('select_multiple');
	foreach ($mul_users as $uid) {
		$user_det = \Drupal\user\Entity\User::load($uid);
			
			$user_det->addRole('student');
			$user_det->save();
	}
	
    drupal_set_message($this->t("@message", ['@message' => 'The Seelcted Students has been assigned the role successfully']));
  }


}
