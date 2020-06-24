<?php

namespace  Drupal\form_module\Services;
use Drupal\Core\Config\ConfigFactoryInterface;


interface ServicesInterface { 
	   public  function store($data); 
}

class FormServices implements ServicesInterface{

 public $data;

public function __construct(ConfigFactoryInterface $config_factory) {
   $this->configFactory = $config_factory;
 } 
 
 

 public function  store($data){
	 // print_r($data);die;
	$key=$data['username'];
	
    // $config = \Drupal::service('config.factory')->getEditable('form_module.settings')->delete();
	
    $config = $this->configFactory->getEditable('form_module.settings');
    // $config = \Drupal::service('config.factory')->getEditable('form_module.settings');
    $config->set($key, $data);
    $config->save();
 }
 
  

}