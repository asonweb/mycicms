<?php

class Search extends HomeController{
	
	protected $cats;
	protected $types;
	
	function __construct(){
		parent::__construct();
		$this->load->library('user_agent');
		if ( $this->agent->is_mobile() or $this->input->get('theme') ==='mobile') {
			Theme::set_theme('mobile');
		}
		if( $this->data['mobile_state'] === 'yes' ){
			Theme::set_theme('mobile');
		}
		$this->data['noresult'] = '没有内容';
		$this->load->library('contentfactory');
		
		//分类
		$this->config->load('cache_categories');
		$this->cats=  $this->config->item('categories');
		//类型
		$this->types = $this->config->item('types');
	}
	
	function index(){
		$options = $this->input->get();
		$options['type'] = 'product';
		//获取内容列表
		$this->load->model('content_model');
		if ( $data = $this->content_model->lists($options) )
		{
			$this->data['lists'] = $data['lists'];
			$this->data['pages'] = $data['pages'];
		}else{
			$this->data['lists'] = '';
			$this->data['pages'] = '';
		}
		
		$this->data['current'] = $options;
		
		//seo title
		if( $options['category'] ){
			$this->data['seo_title'] = $this->cats[$options['category']]['name']."|" .$this->data['seo_title'];
		}else{
			$this->data['seo_title'] = $this->types[$options['type']]['seo_title']."|" .$this->data['seo_title'];
		}
		//output
		$this->_view(Contentfactory::$types[$options['type']]['list'],$this->data);
	}
	
}