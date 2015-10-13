<?php

class Comment extends AdminController{
	
	public $current;
	
	function __construct(){
		parent::__construct();
		
		$this->current = $this->uri->ruri_to_assoc();
		if( $this->input->get() ) { $this->current += $this->input->get();}
	}
	
	function index(){
		$this->load->model('comment_model','model');
		$data = $this->model->lists( $this->current );
		if(!$data) $data= array('list'=>'','pages'=>'');
		$this->data['body'] = $this->load->view('comment/list.html', $data , true);
		Displayview::display('comment/comment.html',$this->data);
	}
	
	function edit($id){
		$this->db->where( 'id', intval( $id ));
		$result = $this->db->get('comments')->result_array();
		$result = array_shift($result);
		auto_charset($result);
		$this->data['form'] = $result;
		Displayview::display('comment/edit.html',$this->data);
	}
	
	function update(){
		$data = $this->input->post();
		unset($data['id']);
		$this->db->update('comments',$data,array('id'=>(int)$this->input->post('id')));
	}
	
	function delete($id){
		$this->db->where('id',(int)$id);
		$this->db->delete('comments');
		redirect($_SERVER['HTTP_REFERER']);
	}
}