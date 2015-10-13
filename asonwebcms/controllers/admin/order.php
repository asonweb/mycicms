<?php

class Order extends AdminController{
	
	protected $table = 'order';
	
	function __construct(){
		parent::__construct();
		
	}
	
	function index(){
		if ($this->input->get('status') ===false) $orders = $this->listsall();
		else $orders = $this->lists();
		$this->data['lists'] = $orders['lists'];
		$this->data['pages'] = !empty($orders['pages']) ? $orders['pages'] : '';
		Displayview::display('order/lists',$this->data);
	}
	
	function edit($id){
		$query = $this->db
		->where('id',intval($id))
		->get($this->table);
		$result = array_shift($query->result_array());
		auto_charset($result);
		
		$this->load->model('admin/content_model');
		
		$this->data['order'] = $result;
		Displayview::display('order/order_form',$this->data);
	}
	
	private function listsall($order=''){
		if (empty($order)) {
			$order = 'order_time desc';
		}
		
		$count = $this->db
		->order_by($order)
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
	
	private function lists($order=''){
		if (empty($order)) {
			$order = 'order_time desc';
		}
		
		$status = $this->input->get('status');
		
		$count = $this->db
		->where('order_status',$status)
		->order_by($order)
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
				
			$query = $this->db->_execute("select * from as_".$this->table . "where order_status='".$status."' order by ".$order);
			$lists = $this->db->limit_access($query,$offset,$pageconfig['per_page']);
			$pages = $this->paged($pageconfig);
			$lists = auto_charset($lists);
				
			$r = array('lists'=>$lists,'pages'=>$pages);
			return $r;
		}else{
			return null;
		}
	}
	
	function update(){
		$status = $this->input->get('status');
		
		$this->db
		->where('id',intval($this->input->post('id')));
		
		if ($status == '1') {
			$data['order_status'] = '2';
			$this->db
			->update('order',$data);
		}
		if ($status == '2') {
			$data['order_status'] = '3';
			$this->db
			->update('order',$data);
		}
		if ($status == '3') {
			$data['order_status'] = '4';
			$this->db
			->update('order',$data);
		}
		redirect('admin/order/index');
	}
	
	function delete($id){
		$this->db
		->where('id',intval($id) );
		$this->db->set('order_status','0');
		$this->db->update('order');
		redirect('admin/order/index');
	}
}