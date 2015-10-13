<?php

class Comment_model extends Base_model{
	
	
	function __construct(){
		parent::__construct();
		$this->table = 'comments';
		$this->pk = 'id';
	}
	
	
	function lists($options){
		//添加测试节点
		$this->benchmark->mark('commentmodel_start');
		if( is_string($options))
		{
			parse_str($options,$where);
			extract($where);
		}else{
			extract($options);
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
	
		//是否限制显示行数
		if ( isset($limit) ) {
			$this->db->limit( $limit );
			$count = $limit;
			return $this->db->get()->result_array();
		}else{
			if ( ( $count = $this->count_by() ) === 0 ) return NULL;
		}
	
		//排序
		if ( !isset( $order ) )
		{
			$order = 'sort asc,createtime desc,id desc';
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
		$pageconfig['total_rows'] = $count;
		if( isset( $pagesize ) and $pagesize )
		{
			$pageconfig['per_page'] = $pagesize;
		}
		$pageconfig['base_url'] = current_url().'?'.http_build_query($querys);
	
		if ( $count <= $pageconfig['per_page'] ){
			//行数小于分页数
			return array('lists'=> $this->db->query( $sql."order by $order" )->result_array(),'pages'=>'');
		}
	
		$pages = $this->paged($pageconfig);	//分页
	
		//偏移行数
		$offset = $pageconfig['per_page'] * ( $this->pagination->cur_page -1 );
	
		$query_result = $this->db->query($sql."order by $order");
		$lists = $query_result->result_array( $offset,$pageconfig['per_page']);
	
		$this->benchmark->mark('commentmodel_end');
		return array('lists'=>$lists,'pages'=>$pages);
	}
}