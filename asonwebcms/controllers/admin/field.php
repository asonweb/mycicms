<?php
/**
 * 
 * 字段管理控制器
 *
 * @param
 * @return void
 */
class Field extends AdminController{
	
	public $field_type_array = array();
	public $field_types;
	
	function __construct(){
		parent::__construct();
		//load	model	libs
		$this->load->model('fields_model');
		$this->load->library(array('fields','form_validation'));
		
		$this->field_types = $this->fields->field_types;
		$this->field_type_array = $this->fields->field_type_array();
		$this->data['field_types'] = $this->field_type_array;
		
		$this->data['url'] = $this->router->fetch_method();
	}
	
	function lists(){
		$lists = $this->fields_model->get_all();
		$count = count($lists);
		$this->load->library('pagination');
		
		$pagination_config = $this->config->item('adminpagination');
		
		if($count > $pagination_config['per_page']){
			$pages = $this->pagination->create_linksshow();
		}
		$this->data['pages'] = $pages ? $pages : '';
		$this->data['lists'] = $lists;
		Displayview::display('field/fields',$this->data);
	}
	
	/**
	 * 输出编辑字段view
	 * 
	 * @param	int $id
	 * @return	void
	 */
	function edit($id){
		$this->data['id'] = $id;
		$this->data['field'] = $this->fields_model->get($id);
		Displayview::display('field/form',$this->data);
	}
	
	function update(){
		$id = $this->input->post('id');
		$result = $this->fields_model->update($id, $this->input->post());
		if ( $result ===false ){
			$this->data['field'] = array_fill_keys($this->fields_model->fields,'');
			Displayview::display('field/form',$this->data);
		}else{
			redirect('admin/field/lists');
		}
	}
	
	/**
	 * 输出添加字段view
	 * 
	 *
	 * @return void
	 */
	function add(){
		Displayview::display('field/form',$this->data);
	}
	
	/**
	 * 输出字段添加页面
	 * create new field
	 *
	 * @param 
	 * @return void
	 */
	function form($id =false){
		
		//验证失败，返回false
		if ( !$data = $this->fields_model->validate( $this->input->post() ) ) {
			Displayview::display('field/form',$this->data);
		}else{
			//添加新字段
			$field_options = $this->field_types->$data['field_type']->custom_parameters;
			foreach ( $field_options as $name=>$val ){
				$field_option[$val] = $data[$val];
				unset($data[$val]);
			}
			$data['field_options'] = serialize($field_option);
			$insert_id = $this->fields_model->insert($data,true);
			redirect('field/lists');
		}
		
	}
	
	public function xhr_build_params(){
			$type = $this->input->post('type');
			$field_type = $this->field_types->$type;
			
			if (!isset($field_type->custom_parameters )) return null;
			$field_options = $field_type->custom_parameters;
			
			$data['count'] = 0;
			
			foreach ($field_options as $field){
				$call = 'option_'.$field;
				if (method_exists($field_type, $call)) {
					$input = $field_type->$call();
					$data['input']	= $input['input'];
					$data['label']	= $input['label'];
					$data['slug']	= $field;
				}else{
					return false;
				}
				ob_get_level() and ob_end_clean();
				echo $this->load->view('field/option_field', $data, true);
				$data['count'] ++;
			}

	}
	
	function insert(){
		$insert_id = $this->fields_model->insert($this->input->post());
	}
}