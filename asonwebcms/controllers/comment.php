<?php

class Comment extends HomeController{
	
	function index(){
		
	}
	
	function add_comment(){
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('name', '姓名', 'required');
		$this->form_validation->set_rules('phone', '手机', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('msg','填写错误，请重新填写');
			if( $this->input->post('dosubmit') ==='' ) redirect($_SERVER['HTTP_REFERER'].'#myform');
				
			redirect($_SERVER['HTTP_REFERER']);
		}
		else
		{
			$data = array(
					'user_name'=>$this->input->post('name'),
					'tel' => $this->input->post('phone'),
					'content' => $this->input->post('content'),
					'createtime' => time(),
			);
			auto_charset($data,'utf-8','gbk');
			$this->db->insert('comments',$data);
			$this->session->set_flashdata('msg','预定成功');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
}