<?php

class Db extends CI_Controller{
	
	
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	function num_rows(){
		$query = $this->db->get('users');
		$query2 = $this->db->get('contents');
		$sql = 'SELECT id,name from as_contents';
		$sql = preg_replace('/select/i', 'select top 1', $sql);
		//print_r($sql);
		print_r($query2->num_rows());
	}
}