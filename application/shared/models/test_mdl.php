<?php

class Test_mdl extends CI_Model{

	public $test_data = 'abc';
	public function __construct(){
		parent::__construct();
	}

	public function get_data(){

		return $this->test_data;
	}
}
