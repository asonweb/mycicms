<?php

class Cart extends HomeController{
	
	function add_to_cart(){
		$this->load->model('content_model');
		
		//要添加到购物车的产品信息
		$cart = array(
				'id'=>$this->input->post('id'),
				'qty' => $this->input->post('num'),
		);
		
		$pro = $this->content_model->get_content(intval($cart['id']));
		$product = array(
			'id'=>	$pro['ID'],
			'qty'=> $cart['qty'],
			'price'=>$pro['price'],
			'name'=>$pro['title'],
		);
		
		$items = $this->cart->contents();
		
		if ( !empty($items) ) {
			//购物车里是否存在，存在加个数
			foreach($items as $item)
			{
				if(intval($item['id']) == intval($product['id']))
				{
					$product['qty'] = $cart['qty'] + $item['qty'];
				}
			}
		}
		$this->cart->insert($product);
		redirect('cart/mycart');
	}
	
	function mycart(){
		
		$this->data['head'] = $this->parser->parse('home/head.html',$this->pagedata,true);
		$this->data['header'] = $this->parser->parse('home/header.html',$this->pagedata,true);
		$this->data['footer'] = $this->parser->parse('home/footer.html',$this->pagedata,true);
		$this->parser->parse('home/cart',$this->data);
	}
}