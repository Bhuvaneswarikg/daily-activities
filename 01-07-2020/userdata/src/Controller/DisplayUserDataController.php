<?php

namespace Drupal\userdata\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;

/**
 * Class DisplayTableController.
 *
 * @package Drupal\userdata\Controller
 */
class DisplayUserDataController extends ControllerBase {


  public function getContent() {
    // First we'll tell the user what's going on. This content can be found
    // in the twig template file: templates/description.html.twig.
    // @todo: Set up links to create nodes and point to devel module.
    $build = [
      'description' => [
        '#theme' => 'userdata_description',
        '#description' => 'foo',
        '#attributes' => [],
      ],
    ];
    return $build;
  }

  /**
   * Display.
   *
   * @return string
   *   Return Hello string.
   */
  public function display() {
    /**return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: display with parameter(s): $name'),
    ];*/

    //create table header
    $header_table = array(
     'id'=>    t('SrNo'),      
        'mobilenumber' => t('Mobile Number'),      
		'age' => t('Age'),      
		'gender' => t('Gender'),      
		'bio' => t('Bio'),      
        
    );

//select records from table
	
    $query = \Drupal::database()->select('userdata', 'm');
	
      $query->fields('m', ['id','mobilenumber','age','gender','bio']);	  
      $results = $query->execute()->fetchAll();
        $rows=array();
    foreach($results as $data){
       

      //print the data from table
             $rows[] = array(
            'id' =>$data->id,
                
                'mobilenumber' => $data->mobilenumber, 
				'age' => $data->age, 
				'gender' => $data->gender, 
				'bio' => $data->bio, 

            );

    }
    //display data in site
    $form['table'] = [
            '#type' => 'table',
            '#header' => $header_table,
            '#rows' => $rows,
            '#empty' => t('No users found'),
        ];
//        echo '<pre>';print_r($form['table']);exit;
        return $form;

  }

}
