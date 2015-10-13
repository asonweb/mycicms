<?php

/**
 * 文本字段类
 * 
 * 来自pyrocms
 * @param
 * @return 
 */

class Field_text {
	
	public $field_type_slug = 'text';
	
	public $field_type_name = '单行文本';
	
	public $version='1.0';
	
	public $custom_parameters		= array('max_length', 'default_value');
	
	public function form_output($data){
		
		$options['name'] = $data['name'];
		$options['id'] = $data['id'];
		$options['value'] = $data['value'];
		
		if(isset($data['max_length']) and is_numeric($data['max_length'])){
			$options['max_length'] = $data['max_length'];
		}
		
		return form_input($options);
	}
	
	/**
	 * 最大值
	 * 输出最大值，应用于 字段类型选择输出
	 *
	 * @param $value
	 * @return <input type="text" />
	 */
	public function option_max_length($value=''){
		$data = array(
			'name'	=> 'max_length',
			'id'	=> 'max_length',
			'value'	=> 	$value,
			'maxlength'	=> '100',
		);
		return array('input'=>form_input($data),'label'=>'最大值');
	}
	
	/**
	 * 默认值
	 * 输出默认值，应用于 字段类型选择输出
	 *
	 * @param	$value 
	 * @return <input type="text" />
	 */
	public function option_default_value($value=''){
		$data = array(
				'name'        => 'default_value',
				'id'          => 'default_value',
				'value'       => $value,
				'maxlength'   => '255'
		);
		
		return array('input'=>form_input($data),'label'=>'默认值');
	}
}