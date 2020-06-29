<?php

namespace Drupal\myform\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class MydataForm.
 *
 * @package Drupal\mydata\Form
 */
class MyformForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'myform_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $conn = Database::getConnection();
     $record = array();
    if (isset($_GET['num'])) {
        $query = $conn->select('myform', 'm')
            ->condition('id', $_GET['num'])
            ->fields('m');
        $record = $query->execute()->fetchAssoc();

    }

    $form['first_name'] = array(
      '#type' => 'textfield',
      '#title' => t('First Name:'),
      '#required' => TRUE,
       //'#default_values' => array(array('id')),
      '#default_value' => (isset($record['name']) && $_GET['num']) ? $record['name']:'',
      );
	  
	  $form['last_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Last Name:'),
      '#required' => TRUE,
       //'#default_values' => array(array('id')),
      '#default_value' => (isset($record['name']) && $_GET['num']) ? $record['name']:'',
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
      '#required' => TRUE,
	  '#default_value' => (isset($record['name']) && $_GET['num']) ? $record['name']:'',
    );
    
    $form['gender'] = array (
      '#type' => 'radios',
      '#title' => ('Gender'),
      '#options' => array(
        'Male' =>t('Male'),
        'Female' =>t('Female'),
		'#default_value' => (isset($record['gender']) && $_GET['num']) ? $record['gender']:'',
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
	  $form['submit'] = [
      '#type' => 'submit',
      // The AJAX handler will call our callback, and will replace whatever page
      // element has id box-container.
      '#ajax' => [
        'callback' => '::promptCallback',
        'wrapper' => 'box-container',
      ],
      '#value' => $this->t('Submit'),
    ];
	
   // $form['submit'] = [
     //   '#type' => 'submit',
       // '#value' => 'save',
        //'#value' => t('Submit'),
    //];

    return $form;
  }

  /**
    * {@inheritdoc}
    */
  public function validateForm(array &$form, FormStateInterface $form_state) {

         
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

  
     }

	public function promptCallback(array &$form, FormStateInterface $form_state) {
    // In most cases, it is recommended that you put this logic in form
    // generation rather than the callback. Submit driven forms are an
    // exception, because you may not want to return the form at all.
    //$element = $form['container'];
    //$element['box']['#markup'] = "Clicked submit ({$form_state->getValue('op')}): " . date('c');
    //return $element;
	  $field=$form_state->getValues();
    $first_name=$field['first_name'];
    //echo "$name";
    $last_name=$field['last_name'];
    $dob=$field['candidate_dob'];
    $gender=$field['gender'];
    
    /*$insert = array('name' => $name, 'mobilenumber' => $number, 'email' => $email, 'age' => $age, 'gender' => $gender, 'website' => $website);
    db_insert('mydata')
    ->fields($insert)
    ->execute();

    if($insert == TRUE)
    {
      drupal_set_message("your application subimitted successfully");
    }
    else
    {
      drupal_set_message("your application not subimitted ");
    }*/

    if (isset($_GET['num'])) {
          $field  = array(
              'first_name'   => $first_name,
              'last_name' =>  $last_name,
              'dob' =>  $dob,              
              'gender' => $gender,              
          );
          $query = \Drupal::database();
          $query->update('myform')
              ->fields($field)
              ->condition('id', $_GET['num'])
              ->execute();
          //drupal_set_message("succesfully updated");
          //$form_state->setRedirect('myform.display_table_controller_display');

      }

       else
       {
           $field  = array(
              'first_name'   => $first_name,
              'last_name' =>  $last_name,
              'dob' =>  $dob,              
              'gender' => $gender,
          );
           $query = \Drupal::database();
           $query ->insert('myform')
               ->fields($field)
               ->execute();
           drupal_set_message("succesfully saved");

           $response = new RedirectResponse("/drupal2/web/myform/hello/table");
         $response->send();
       }
  }
}
