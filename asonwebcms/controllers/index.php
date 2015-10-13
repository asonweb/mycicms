<?php

class Index extends HomeController{
	
	protected $types;
	protected $type;
	protected $pagedata;
	
	function __construct(){
		parent::__construct();
		$this->types = $this->config->item('types');
	}
	
	function index(){
		$this->data['head'] = $this->parser->parse('head.html',$this->pagedata,true);
		$this->data['header'] = $this->parser->parse('header.html',$this->pagedata,true);
		$this->data['footer'] = $this->parser->parse('footer.html',$this->pagedata,true);
		
		$this->parser->parse('index.html',$this->data);
	}
	
	/*
	 * 列表用于分页
	 * @param $type str 类型
	 * @param $id 分类id
	 */
	function lists($type,$id =false,$p=0){
		//内容类型
		$this->type = $this->types[$type];
		
		//加载内容模型,模型读取分页数据
		$this->load->model('content_model');
		$data2 = $this->content_model->lists($type,$id);
		
		$this->data['comps_list'] = $this->load->view($this->type['list_comps'], $data2, true);
		$this->data['head'] = $this->parser->parse('home/head-page',$this->pagedata,true);
		$this->data['header'] = $this->parser->parse('home/header.html',$this->pagedata,true);
		$this->data['footer'] = $this->parser->parse('home/footer.html',$this->pagedata,true);
		//output
		$this->parser->parse($this->type['tpllist'],$this->data);
	}
	
	function view($type,$id){
		//内容类型
		$this->type = $this->types[$type];
		
		$query = $this->db
		->where('id',intval($id) )
		->get('contents');
		$data = auto_charset($query->row_array());
		//views
		$this->data['head'] = $this->parser->parse('home/head-page',$this->pagedata,true);
		$this->data['header'] = $this->parser->parse('home/header.html',$this->pagedata,true);
		$this->data['footer'] = $this->parser->parse('home/footer.html',$this->pagedata,true);
		$this->data['content'] = $data;
		$this->parser->parse($this->type['tpl'],$this->data);
	}
	
	
}