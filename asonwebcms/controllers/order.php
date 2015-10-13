<?php


class Order extends HomeController{
	
	
	function save_order() {
		
		$user = $this->session->userdata('user');
		
		$save	= array();
	
		$save['order_status'] = 1;
		//序列化会员信息
		$save['order_name'] = json_encode($user[0]);
		$save['uid'] = $user[0]['id'];
		$save['order_time'] = time();
		$save['order_total'] = $this->cart->total();
		$save['order_mark'] = $this->input->post('order_mark');
		//序列化产品信息
		$save['order_products'] = json_encode($this->cart->contents());
		
		//create ,get insert id
		$this->db->insert('order',$save);
		$result= $this->db->query( "SELECT @@IDENTITY as insert_id" );
		$insert_id = array_shift($result->result_array());
		$insert_id = $insert_id['insert_id'];
		
		//订单号，根据时间来生成 唯一的编号
		$data = array('order_id'=> date('U').$insert_id );
		//更新订单号
		$this->db->where('id' , intval($insert_id) );
		$this->db->update('order',$data);
		
		$this->cart->destroy();
		redirect('index/lists/product');
	}
}