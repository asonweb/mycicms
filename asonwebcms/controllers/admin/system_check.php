<?php

/**
 * 系统工具类
 * 
 * 1.生成静态首页html
 *
 * @package		asonwebcms
 * @author		nick <authen@qq.com>
 */
class System_check extends AdminController{
	
	function __construct(){
		parent::__construct();
	}
	
	/**
	 * 输出操作界面
	 */
	function index() {
		Displayview::display('tools/index',$this->data);
	}
	
	/**
	 * 生成首页html文件
	 * 
	 * 生成位置是网页根目录 index.html
	 *
	 * @param
	 * @return void
	 */
	function create_home_html(){
		$this->load->helper('file_helper');
		$str = file_get_contents(site_url());
		write_file(FCPATH.'\index.html', $str);
		redirect($_SERVER['HTTP_REFERER']);
	}
}