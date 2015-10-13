<?php
/*
 * admin/content
 * 内容管理控制器
 */
class Content extends AdminController{
	
	public $model;
	public $current;
	
	function __construct(){
		parent::__construct();
		
		$this->load->helper('form');
		$this->load->library(array('contentfactory','tree'));
		$this->load->model('content_model','model');
		$this->load->model( 'category_model' );
		$this->current = $this->uri->ruri_to_assoc();
		if( $this->input->get() ) { $this->current += $this->input->get();}

		if($this->data['action'] !== 'delete'){
			$this->data['name'] = Contentfactory::$types[$this->current['type']];
		}
		
		$this->config->load('position',true);
	}
	
	/**
	 * 列表页
	 * 
	 *
	 * @param 
	 */
	public function index(){
		//分类 select options
		$cats = $this->category_model->lists();
		$this->tree->init( $cats );
		if( !isset( $this->current['catid'] )) $this->current['catid'] = '';
		$this->data['categories'] = $this->tree->get_tree_select(0,"<option value=\$id \$selected>\$spacer\$name</option>", $this->current['catid']);
		
		if( !isset( $this->current['position'] )) $this->current['position'] = '';
		$options = $this->config->item('position','position');
		$options = array(''=>'推荐位管理') + $options;
		$this->data['positions'] = form_dropdown('position',$options,$this->current['position'],'class="input input-auto"');
		
		$data = $this->model->lists( $this->current );
		if(!$data) $data= array('lists'=>'','pages'=>'');
		
		$data['name'] = $this->data['name'];
		$data['categories'] = $this->data['categories'];	//分类select
		$data['categories_lists'] = $this->category_model->categories;
		$this->data['body'] = $this->load->view( 'content/list', $data, true );
		
		Displayview::display('content/content',$this->data);
	}
	
	/**
	 * 输出添加page
	 * 
	 * @param
	 */
	public function add(){
	
		$this->data['forward'] = $_SERVER['HTTP_REFERER'];
		
		$this->tree->init($this->category_model->lists($this->current));
		$this->data['categories'] = $this->tree->get_tree_select(0,"<option value=\$id \$selected>\$spacer\$name</option>");
		$this->data['form'] = $this->load->view('content/'.Contentfactory::$types[$this->current['type']]['addform'], $this->data, true);
		Displayview::display('/content/add.html',$this->data);
	}
	
	/**
	 * 插入数据库
	 * 
	 *
	 * @param
	 */
	public function insert(){
		$this->load->library('form_validation');	
		$this->form_validation->set_rules('title', '标题', 'required');
		
		if ($this->form_validation->run() !== FALSE)
		{
			$data = $this->input->post();
			if( empty( $data['createtime'] ) ) $data['createtime'] = time();
			if( !empty( $data['pos'] ))	$data['pos'] = implode(',', $data['pos']);
			unset($data['editorValue'],$data['forward']);
			
			if( $this->input->post('hits') =='') $data['hits'] = 0;
			$r = $this->model->insert($data);
			redirect($this->input->post('forward'));
		}
		else
		{
			$this->data['form'] = $this->load->view($this->config->item('theme').'/content/'.$this->data['name']['addform'], $this->data, true);
			Displayview::display('content/add.html',$this->data);
		}
	}
	
	/**
	 * 输出编辑page
	 * 
	 *
	 * @param
	 * @return void
	 */
	public function edit(){
		$id = $this->current['id'];
		
		$content = $this->model->get( $id );

		$this->tree->init($this->category_model->lists( $this->current + array('fetch'=>'') ));
		$this->data['categories'] = $this->tree->get_tree(0,"<option value=\$id \$selected>\$spacer\$name</option>", $content['catid']);
		
		$this->data['content'] = $content;
		$this->data['forward'] = $_SERVER['HTTP_REFERER'];
		$this->data['form'] = $this->load->view('content/'.Contentfactory::$types[$this->current['type']]['editform'], $this->data, true);
		unset($this->data['content']);
		Displayview::display('content/edit.html',$this->data);
	}
	
	/**
	 * 更新数据
	 * 
	 *
	 * @param
	 */
	public function update(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', '标题', 'required');
		$this->form_validation->set_rules('forward', '标题', 'required');
		
		$id = $this->input->post('id');
		
		if ($this->form_validation->run() !== FALSE)
		{
			$data = $this->input->post();
			$data['pos'] = implode(',', $data['pos']);
			$data['createtime'] = strtotime($data['createtime']);
			
			if( $this->input->post('hits') =='') $data['hits'] = 0;
			
			$r = $this->model->update($id,$data);

			if ($r!==false)
				redirect($this->input->post('forward'));	//列表页
		}else{
			redirect($_SERVER['HTTP_REFERER']);
		}
		
	}
	
	public function delete($id=null){

		if (isset( $this->current['trash'] )) {
			if ($this->current['trash']=='trash') {
				//删除到回收站
				$this->model->update( $id, array('status'=>'0') );
			}elseif ( $this->current['trash'] =='trashin' ){
				//批量删除到回收站
				if( $this->input->post('id') ){
					foreach ( $this->input->post('id') as $ids ){
						$this->model->update( $ids, array('status'=>0) );
					}
					
				}
			}elseif (  $this->current['trash'] =='deleteain' ){
				//批量从数据库删除
				
				if( $this->input->post('id') ){
					foreach ( $this->input->post('id') as $ids ){
						$this->model->delete( intval($ids) );
					}
				}else{
					//$this->db->delete( 'contents',array('status'=>0));
				}
			}elseif ( $this->current['trash'] =='delete' ){
				//从数据库删除
				$this->model->delete( (int)$id );
			}
		}
		if ( isset( $this->current['restore'] ) ){
			if( $this->current['restore'] =='restore'){
				$this->model->update( $id, array('status'=>'1') );
			}elseif (  $this->current['restore'] =='restorein'){
				if( $this->input->post('id') ){
					foreach ( $this->input->post('id') as $ids ){
						$this->model->update( $ids, array('status'=>'1') );
					}
				}
			}
		}
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	/**
	 * action 转移分类
	 * 根据select的值来更新分类
	 *
	 * @access	public
	 * @param	string	$name	name of the marker
	 * @return	void
	 */
	public function update_cat(){
		$ids = $this->input->post('id');
		$to_catid = $this->input->post('cat');
		foreach($ids as $id){
			$this->db->update('contents',array('catid'=>$to_catid),array('id'=>intval($id)));
		}
		redirect($_SERVER["HTTP_REFERER"]);
	}
	
	/**
	 * 排序数字更新
	 * 
	 *
	 * @param
	 * @return void
	 */
	public function update_sort(){
		$ids = $this->input->post('sort');
		foreach($ids as $id=>$sort){
			$this->db->update('contents',array('sort'=>$sort),array('id'=>intval($id)));
		}
		redirect( $_SERVER['HTTP_REFERER']);
	}
	
	public function move(){
		
	}
	public function copy(){
		
	}
}