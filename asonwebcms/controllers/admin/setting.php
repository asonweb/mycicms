<?php

class Setting extends AdminController{
	
	function __construct(){
		parent::__construct();
	}
	
	//request 系统设置
	public function index(){
		//site
		$this->data['site'] = $this->setting_model->get_setting('site');
		//contact
		$this->data['contact'] = $this->setting_model->get_setting('contact');
		//seo
		$this->data['seo'] = $this->setting_model->get_setting('seo');
		
		
		Displayview::display('system/system.php',$this->data);
	}
	
	//更新系统设置
	public function save(){
		$id = $_POST['id'];
		unset($_POST['id']);
		$r = $this->setting_model->update(intval($id), array('option_value'=>json_encode($_POST)));
		if($r!==false)
			redirect('admin/setting');
		else 
			show_error('保存失败！');
	}
}