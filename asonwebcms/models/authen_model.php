<?php
class Authen_model extends CI_Model{
	
	function authen($userlogin,$password){
		$q=$this
		->db
		->where('user_login',$userlogin)
		->where('user_pass',$password)
		->limit(1)
		->get('users');
		
		//$q->num_rows acccess数据库返回 -1
		//is_array来判断返回值类型， count()返回记录数,单单count的话不管是否符合都返回1
		$r = $q->result_array();
		if (count($r) > 0)
			return true;
		else
			return false;
	}
	
	
}