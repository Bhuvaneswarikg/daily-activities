<?php

namespace Drupal\userdata\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class userdataForm.
 *
 * @package Drupal\userdata\Form
 */
class UserdataForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'userdata_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $conn = Database::getConnection();
     $record = array();
    if (isset($_GET['num'])) {
        $query = $conn->select('userdata', 'm')
            ->condition('id', $_GET['num'])
            ->fields('m');
        $record = $query->execute()->fetchAssoc();

    }

    

    $form['mobile_number'] = array(
      '#type' => 'textfield',
      '#title' => t('Mobile Number:'),
      '#default_value' => (isset($record['mobilenumber']) && $_GET['num']) ? $record['mobilenumber']:'',
      );

    

    $form['candidate_age'] = array (
      '#type' => 'textfield',
      '#title' => t('AGE'),
      '#required' => TRUE,
      '#default_value' => (isset($record['age']) && $_GET['num']) ? $record['age']:'',
       );
	
	$form['gender'] = array (
      '#type' => 'textfield',
      '#title' => t('Gender'),
      '#required' => TRUE,
      '#default_value' => (isset($record['gender']) && $_GET['num']) ? $record['gender']:'',
       );

    

    $form['bio'] = array (
      '#type' => 'textfield',
      '#title' => t('Bio'),
      '#default_value' => (isset($record['bio']) && $_GET['num']) ? $record['bio']:'',
       );

    $form['submit'] = [
        '#type' => 'submit',
        '#value' => 'save',
        //'#value' => t('Submit'),
    ];

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

    $field=$form_state->getValues();   
    
    $number=$field['mobile_number'];
    $gender=$field['gender'];
    $age=$field['candidate_age'];    
    $bio=$field['bio'];
    if (isset($_GET['num'])) {
          $field  = array(
              
              'mobilenumber' =>  $number,              
              'age' => $age,
              'gender' => $gender,
              'bio' => $bio,
          );
          $query = \Drupal::database();
          $query->update('userdata')
              ->fields($field)
              ->condition('id', $_GET['num'])
              ->execute();
          drupal_set_message("succesfully updated");
          $form_state->setRedirect('userdata.display_table_controller_display');

      }

       else
       {
           $field  = array(
              
              'mobilenumber' =>  $number,              
              'age' => $age,
              'gender' => $gender,
              'bio' => $bio,
          );
           $query = \Drupal::database();
           $query ->insert('userdata')
               ->fields($field)
               ->execute();
           //drupal_set_message("succesfully saved");

           $response = new RedirectResponse("/drupal2/web/userdata/form/user");
           $response->send();
       }
     }

}
