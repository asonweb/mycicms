<?php

class Fields{
	
	public $field_types ;
	public $paths;
	
	function __construct(){
		$this->CI = &get_instance();
		$this->CI->load->helper('directory');
		
		$this->field_types = new stdClass();
		//找到字段类型文件的路径，然后加载进来
		$this->paths = array('core'=> APPPATH.'libraries/fields/');
		$this->load_field_types($this->paths['core']);
		
	}
	
	function load_field_types($path){
		$map = directory_map($path);

		foreach ($map as $file){
			$type = str_replace('.php', '', $file);
			$this->field_types->$type = $this->_load_field_type($path,$file, $type);
		}
	}
	
	private function _load_field_type($path,$file,$type){
		require_once $path.$file;
		
		$tmp = new stdClass();
		$class_name = 'Field_'.$type;
		
		if(class_exists($class_name)){
			$tmp = new $class_name;
			return $tmp;
		}
	}
	
	/*
	 * drop down
	 */
	function field_type_array($types=null){
		
		if (!$types	) {
			$types = $this->field_types;
		}
		
		$return  = array();
		
		if(!$types)  return array();
		
		foreach ($types as $type){
			$return[$type->field_type_slug] = $type->field_type_name;
		}
		return $return;
	}
}