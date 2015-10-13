<?php

// +----------------------------------------------------------------------
// | 二次开发
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.asonweb.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: nick <authen@qq.com>
// +----------------------------------------------------------------------

defined('BASEPATH') OR exit('No direct script access allowed');

class My_Controller extends CI_Controller{
	

}
/*
 * core/MY_AdminController
 * 后台默认控制器
 */
class AdminController extends CI_Controller{
	
	protected $data;
	
	function __construct(){
		parent::__construct();
		
		$this->init();
		$this->data['subnavs'] = $this->config->item('types');
	}
	
	private function init(){
		//load library : email,session
		//load helper:	array('cookie', 'language','url')
		//load config:	ion_auth, 还有语言文件
		//权限验证
		//$this->load->library(array('ion_auth','form_validation'));
		
		//当前请求分组 控制器 方法
		$group = substr($this->router->fetch_directory(),0,-1);//当前分组
		$controller = $this->router->fetch_class();//当前控制器
		$this->data['action'] = $this->router->fetch_method(); //当前控制器方法
		$this->data['controller'] = $controller.'/';
		$this->data['action_url'] = $group.'/'.$controller.'/';
		$this->data['action_group'] = $group . '/';
		//设置模板
		Theme::set_theme('pintuer2');
		
		if( !$this->ion_auth->is_admin() and $this->data['action']!='login' ) redirect( $this->data['action_group'] . 'auth/login'); 
		
		$this->load->model(
				array(
						'base_model',
						'setting_model',
				),'',true);
		//load config
		$this->config->load('content_types','admin.pagination');
		$this->load->helper(array('my','html','form'));
		
	}
	
	function _render_page($view, $data=null, $render=false)
	{
	
		$this->viewdata = (empty($data)) ? $this->data: $data;
	
		$this->load->view('public.header.html',$this->viewdata);
		$view_html = $this->load->view( $this->data['controller'].$view, $this->viewdata, $render);
		$this->load->view('public.footer.html');
	
		if (!$render) return $view_html;
	}
}

