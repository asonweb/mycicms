<?php

class Displayview{
	
	public static function display($tplname,$data=array()){
		$ci = &get_instance();
		$ci->load->view('public.header.html',$data);
		$ci->load->view($tplname);
		$ci->load->view('public.footer.html');
		
	}
}