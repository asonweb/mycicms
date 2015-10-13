<?php

/**
 * 字段管理模型
 * 
 *
 * @param
 * @return void
 */
class Fields_model extends Base_model{
	
	public $table='fields';
	
	public $pk = 'id';
	
	protected $validate = array(
			array( 'field' => 'field_name',
					'label' => '字段名称',
					'rules' => 'required|is_unique[fields.field_name]'),
			array( 'field' => 'field_slug',
					'label' =>'字段标识',
					'rules' => 'required|is_unique[fields.field_slug]'),
	);
	
	public function insert_field(){
		
	}
	
}