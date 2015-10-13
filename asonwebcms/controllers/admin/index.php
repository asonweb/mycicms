<?php
class Index extends AdminController{
	
	function __construct(){
		parent::__construct();
	}
	/*
	 * 后台登陆首页（默认页）
	 */
	public function index(){
		
		Displayview::display('index.html',$this->data);
	}
	/*
	 * 注销退出
	 */
	public function loginout(){
		$this->session->sess_destroy();
		$this->load->view('login.html',$this->$data);
	}
}