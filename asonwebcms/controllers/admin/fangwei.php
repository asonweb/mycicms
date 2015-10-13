<?php

class fangwei extends AdminController{
	
	
	function index(){
		$db2 =$this->load->database('fangwei',true);
		$codes = $db2->get('fangwei');
		$codes = $codes->result_array();
		$this->data['lists'] = $codes;
		Displayview::display('fangwei/lists',$this->data);
	}
	
	function create(){
		$this->load->library('bcrypt');
		$db2 =$this->load->database('fangwei',true);
		
		$codes = array();
		for ( $i=0;$i<1;$i++)
		{
			$input = $this->make_password();
			$input = $this->bcrypt->hash($input);
			$codes['code'] = $input;
		}
		$db2->trans_start();
		$result = $db2->insert('fangwei',$codes);
		$db2->trans_complete();
		redirect('admin/fangwei/index');
	}
	
	function edit($id){
		$db2 =$this->load->database('fangwei',true);
		$result = $db2->get_where('fangwei',array('id'=>intval($id)) );
		$result = array_shift($result->result_array());
		$this->data['view'] = $result;
		Displayview::display('fangwei/fangwei_form',$this->data);
	}
	
	function update(){
		$db2 =$this->load->database('fangwei',true);
		$db2->set('status',$this->input->post('status'));
		$result = $db2->where('id',intval($this->input->post('id')))->update('fangwei');
		if($result) Displayview::display('fangwei/index',$this->data);
	}
	
	private function make_password( $length = 4 )
	{
	    // 密码字符集，可任意添加你需要的字符
	    $chars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 
	    'i', 'j', 'k', 'l','m', 'n', 'o', 'p', 'q', 'r', 's', 
	    't', 'u', 'v', 'w', 'x', 'y','z', 'A', 'B', 'C', 'D', 
	    'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L','M', 'N', 'O', 
	    'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y','Z', 
	    '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
	
	    // 在 $chars 中随机取 $length 个数组元素键名
	    $keys = array_rand($chars, $length); 
	
	    $password = '';
	    for($i = 0; $i < $length; $i++)
	    {
	        // 将 $length 个数组元素连接成字符串
	        $password .= $chars[$keys[$i]];
	    }
	
	    return $password;
	}
}