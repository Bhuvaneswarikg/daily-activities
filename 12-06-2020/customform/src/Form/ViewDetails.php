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
class ViewDetails extends FormBase {


public $configid;
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $configid=NULL) {
    
    $config = \Drupal::config('form_module.settings');
    $uservalue = $config->get(); 
	
	// echo'<pre>';print_r($uservalue);
	
    // Password Confirm.
   //Table
	// $options = [
      // 1 => ['first_name' => 'Bat', 'last_name' => 'Man'],
      // 2 => ['first_name' => 'Darth', 'last_name' => 'Vader'],
      // 3 => ['first_name' => 'Super', 'last_name' => 'Man'],
    // ];
// echo'<pre>';print_r($options);die;


foreach ($uservalue as $k=>$subArr) {
        foreach ($subArr as $key => $value) {

            if ($key == id) {
                unset($uservalue[$k][$key]);
            }
			
			 if ($key == 'assign_status') {
				if ($uservalue[$k][$key] == 0) {
					// print_r($uservalue[$k][$key]); die;
					$uservalue[$k][$key] = 'Not Assigned';
				} else {
					$uservalue[$k][$key] = 'Assigned';
				}
               //print_r($uservalue[$k][$key]); die;
            }

        }
    }

$options =$uservalue;

    $header = [
      'username' => $this->t('UserName'),
      'rollno' => $this->t('Roll No'),
      'assign_status' => $this->t('Status'),
    ];

    $form['table'] = [
      '#type' => 'tableselect',
      '#title' => $this->t('Users'),
      '#header' => $header,
      '#options' => $options,
      '#empty' => $this->t('No Data Found'),
    ];
	
	$form['userid']=$configid;
	
    $form['actions']['#type'] = 'actions';

    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Assign'),
      '#button_type' => 'primary',
    );
	

    return $form;
  }

     /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // valiodate form values
    if ($form_state->getValue('table') == '') {
      $msg = t('<strong>Password is required!</strong>');
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
    
	
	$ids=$form_state->getValue('table');
	//echo'<pre>';print_r($ids);die;
	foreach($ids as $key => $value){
		
		
		$config = \Drupal::config('form_module.settings');
		$uservalue = $config->get($key); 
		
		// echo'<pre>';print_r($uservalue);die;
		
		$user = \Drupal\user\Entity\User::load($uservalue['id']);
		$user->addRole('student');
		$user->save();
		
		
		// To check roles of user
		$users = \Drupal::entityTypeManager()->getStorage('user')->loadByProperties(['uid' => $uservalue['id']]);
		
		$user = reset($users);
		
		if ($user) {
		  $uid = $user->id();
		  $rids = $user->getRoles();
		}
		// To check roles of user
			
		$config = \Drupal::service('config.factory')->getEditable('form_module.settings');
		$config->set($key.'.assign_status', 1);
		$config->save();
			
	}
    
   
    drupal_set_message($this->t("@message", ['@message' => 'Password Successfully Updated.']));
  }


}
