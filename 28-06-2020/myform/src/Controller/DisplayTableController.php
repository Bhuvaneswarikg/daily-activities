<?php

namespace Drupal\myform\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;

/**
 * Class DisplayTableController.
 *
 * @package Drupal\myform\Controller
 */
class DisplayTableController extends ControllerBase {


  public function getContent() {
    // First we'll tell the user what's going on. This content can be found
    // in the twig template file: templates/description.html.twig.
    // @todo: Set up links to create nodes and point to devel module.
    $build = [
      'description' => [
        '#theme' => 'myform_description',
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
	  echo "ferefe"; exit;
    /**return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: display with parameter(s): $name'),
    ];*/

    //create table header
    $header_table = array(
     'id'=>    t('SrNo'),
      'first_name' => t('First Name'),
        'last_name' => t('Last Name'),
        'dob'=>t('Date of Birth'),        
        'gender' => t('Gender'),
        //'website' => t('Web site'),
        'opt' => t('operations'),
        'opt1' => t('operations'),
    );

//select records from table
    $query = \Drupal::database()->select('myform', 'm');
      $query->fields('m', ['id','first_name','last_name','dob','gender']);
      $results = $query->execute()->fetchAll();
        $rows=array();
		print "<pre>";
		print_r($results);
		die();
    foreach($results as $data){
        $delete = Url::fromUserInput('/myform/form/delete/'.$data->id);
        $edit   = Url::fromUserInput('/myform/form/myform?num='.$data->id);

      //print the data from table
             $rows[] = array(
            'id' =>$data->id,
                'first_name' => $data->first_name,
                'last_name' => $data->last_name,
                'dob' => $data->dob,                
                'gender' => $data->gender,
                //'website' => $data->website,

                 \Drupal::l('Delete', $delete),
                 \Drupal::l('Edit', $edit),
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
