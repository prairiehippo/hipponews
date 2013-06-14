<?php
namespace Model;

abstract class Model {
	protected $db;

    public function __construct(){
        $this->setup_database();
    }

    protected function setup_database(){
    	$application = \MasterController::get_instance();
    	$this->db = $application->get_database();
    }
}