<?php

/**
 * @file
 * Contains \Drupal\event_form\Form\DemoEventDispatchForm.
 */

namespace Drupal\event_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\event_form\ExampleEvent;

/**
 * Class DemoEventDispatchForm.
 *
 * @package Drupal\event_form\Form
 */
class DemoEventDispatchForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'event_dispatch_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    //$form['name'] = array(
      //'#type' => 'textfield',
      //'#title' => $this->t('Reference'),
      //'#description' => $this->t('Type something here that will be set to the event object, while subscribing it.'),
      //'#maxlength' => 64,
      //'#size' => 64,
    //);
	
	$form['first_name'] = array(
      '#type' => 'textfield',
      '#title' => t('First Name:'),
            
      );
	  
	  $form['last_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Last Name:'),
      
      );
	  
	  $vid = 'interests';
$terms =\Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid);

		
		
	foreach ($terms as $term) {
		 $term_data[] = array(
		  'id' => $term->tid,
		  'name' => $term->name
		 );
		 $taxonomylists[$term->tid] = $term->name; 
	}


	
	//print "<pre>";
    //print_r($userlist);die();    
	
	$form['candidate_dob'] = array (
      '#type' => 'date',
      '#title' => t('DOB'),
      
    );
    
    $form['gender'] = array (
      '#type' => 'radios',
      '#title' => ('Gender'),
      '#options' => array(
        'Male' =>t('Male'),
        'Female' =>t('Female'),
		
      ),
    );   
	
	
    $form['interests'] = array (
      '#type' => 'select',
      '#title' => ('Interests'),
	  '#multiple' => TRUE,
      '#options' => array(
        'Select Taxonomy' => $taxonomylists,      
        
        ),
     );
	 
    $form['dispatch'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Dispatch'),
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Following is the example for
    // How to dispatch an event in Drupal 8?
    $dispatcher = \Drupal::service('event_dispatcher');
    $event = new ExampleEvent($form_state->getValue('first_name'));

    $dispatcher->dispatch(ExampleEvent::SUBMIT, $event);
  }
}
