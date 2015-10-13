<?php

class fangwei extends HomeController{
	
	function index(){
		
		$this->data['head'] = $this->parser->parse('home/head-page',$this->pagedata,true);
		$this->data['header'] = $this->parser->parse('home/header.html',$this->pagedata,true);
		$this->data['footer'] = $this->parser->parse('home/footer.html',$this->pagedata,true);
		$this->parser->parse('home/fangwei',$this->data);
	}
	
	function authen(){
		if ($this->session->userdata('verify_code') == $this->input->post('verify_code')) {
			$db2 = $this->load->database('fangwei',true);
			$result = $db2->get_where('fangwei',array('code'=> $this->input->post('code') )  );
			$result = $result->result_array();
			if (empty($result)) {
				$this->session->set_flashdata('message','false');
			}else{
				$this->session->set_flashdata('message','true');
			}
			redirect('fangwei/index');
		}else{
			$this->session->set_flashdata('message','验证码错误');
			redirect('fangwei/index');
		}
	}
}