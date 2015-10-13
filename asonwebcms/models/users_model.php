<?php

class Users_model extends CI_Model{
	
	protected $table = 'users';
	
	public $pk = 'id';
	
	function __construct(){
		parent::__construct();
	}
	
	function is_login(){
		if ( $this->session->userdata('user')) {
			return true;
		}else{
			return false;
		}
	}
	
	/*
	 * 验证登录账号密码
	 * @funcs md5加密
	 * @return
	 * 如果登录成功，返回 账号信息
	 * 如果失败，返回 false
	 */
	function authen(){
		$query = $this->db
		->where('user_login',$this->input->post('user_name'))
		->where('user_pass',md5($this->input->post('user_pass')));
		$query = $this->db->get($this->table);
		$query = $query->result_array();
		if (!empty($query)) return $query; 
		else return false;
	}
	
	/*
	 * create user
	 * update user info
	 */
	function save($user)
	{
		if ($user['id'])
		{
			$this->db->where('id', $user['id']);
			$this->db->update($this->table, $user);
			return $user['id'];
		}
		else
		{
			$this->db->insert($this->table, $user);
			return $this->db->insert_id();
		}
	}
	
	function get_users(){
		$users = $this->lists();
		return $users;
	}
	
	private function lists($order=''){
		if (empty($order)) {
			$order = 'id desc';
		}
		
		$status = $this->input->get('status') ===false ? '1' : $this->input->get('status');
		
		$count = $this->db
		->order_by($order)
		->where('status',$status)
		->get($this->table);
		$count = $count->result_array();
		
		if (count($count) > 0) {
			//分页 1.load 分页类，2.加载分页配置，
			$this->load->library('pagination');
			$this->config->load('pagination');
			$pageconfig = $this->config->item('pagination');
				
			$pageconfig['total_rows'] = count($count);
			$pageconfig['base_url'] = site_url('user/index');
				
			if (count($count) < $pageconfig['per_page'] ){
				auto_charset($count);
				return array('lists'=>$count);
			}
				
			$offset = $pageconfig['per_page'] * ($this->uri->segment(3,1) -1);
				
			//return resource object
				
			$query = $this->db->_execute("select * from as_".$this->table . "order by ".$order);
			$lists = $this->db->limit_access($query,$offset,$pageconfig['per_page']);
			$pages = $this->paged($pageconfig);
			$lists = auto_charset($lists);
				
			$r = array('lists'=>$lists,'pages'=>$pages);
			return $r;
		}else{
			return null;
		}
	}
}