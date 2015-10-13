<?php

class Content_model extends Base_model{
	
	//数据表名称
	public $table ='contents';
	//主键名称
	public $pk = 'id';
	
	public $position;
	
	function __construct(){
		parent::__construct();
		
		$this->load->library( array('contentfactory') );
		
		$this->config->load('position',true);
		$this->position = $this->config->item('position','position');
	}
	
	/*
	 * 内容列表
	* @param $options array(
	* 	'type'=>'',	内容类型
	* 	'category'=>'',	分类
	* 	'keywords'=>''	内容名称
	* 	''
	* )
	* @param $category
	*/
	function lists($options){
		//添加测试节点
		$this->benchmark->mark('contentmodel_start');
		if( is_string($options))
		{
			parse_str($options,$where);
			extract($where);
		}else{
			extract($options);
		}

		//内容类型
		if ( isset( $type ) )
		{
			$this->db->where('typeid', Contentfactory::$types[$type]['id']);
		}
		//分类id 默认位 '',所以不能用isset
		if( isset($catid) and $catid ) $category = $catid;
		if ( isset($category) and $category )
		{
			$this->load->model('category_model');
			$catids = $this->category_model->get_childids($category);
			
			//有无子类
			if ($catids == false) {
				$catids =$category;
			}else{
				$catids = substr($catids, 1);
				$catids = explode(',', $catids);
			}
			$this->db->where_in('catid',$catids);
			unset($catids);
		}
		//关键词模糊查询
		if ( isset( $keywords ) and $keywords )
		{
			$this->db->like( 'title', auto_charset($keywords,'utf-8','gbk') );
		}
		
		if( isset($position) and $position )
		{
			$this->db->where('pos',$position);	//不支持多选
		}
		
		if (isset($status) and $status=='trash') {
			$this->db->where('status', '0' );
		}else {
			$this->db->where('status', '1' );
		}
		
		$this->db->from($this->table);
		
		//count_by 之前保存查询条件sql 因为count_all_results 会重置查询条件
		$sql = $this->db->_compile_select();
		//var_dump($sql);
		
		//排序
		if ( !isset( $order ) )
		{
			$order = 'sort asc,createtime desc,id desc';
		}
		
		//是否限制显示行数
		if ( isset($limit) ) {
			if( $limit=='all' ){
				return $this->db->order_by($order)->get()->result_array();
			}else{
				$this->db->limit( $limit );
				$count = $limit;
				return $this->db->order_by($order)->get()->result_array();
			}
		}else{
			if ( ( $count = $this->count_by() ) === 0 ) return NULL;
		}
		
		//分页类
		$this->load->library('pagination');
		if ( substr($this->router->fetch_directory(),0,-1) =='admin') {
			$this->config->load('admin.pagination');	//引入后台分页配置
		}else{
			$this->config->load('pagination');	//引入后台分页配置
		}
		$pageconfig = $this->config->item('pagination');
		
		//分页url
		parse_str($_SERVER['QUERY_STRING'],$querys);
		unset( $querys[$pageconfig['query_string_segment']] );
		$this->pagination->total_rows = $pageconfig['total_rows'] = $count;
		if( isset( $pagesize ) and $pagesize )
		{
				$pageconfig['per_page'] = $pagesize;
		}
		$pageconfig['base_url'] = current_url().'?'.http_build_query($querys);
		if ( $count <= $pageconfig['per_page'] ){
			//行数小于分页数
			return array('lists'=> $this->db->query( $sql." order by $order" )->result_array(),'pages'=>'');
		}
		
		$pages = $this->paged($pageconfig);	//分页
		
		//偏移行数
		$offset = $pageconfig['per_page'] * ( $this->pagination->cur_page -1 );
		
		$query_result = $this->db->query($sql." order by $order");
		
		$lists = $query_result->result_array( $offset,$pageconfig['per_page']);
		
		$this->benchmark->mark('contentmodel_end');
		return array('lists'=>$lists,'pages'=>$pages);
	}
	
	
	protected function paged($pageconfig){
		$this->pagination->initialize($pageconfig);
		return $this->pagination->create_linksshow();
	}
}

