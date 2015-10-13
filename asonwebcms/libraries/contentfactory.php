<?php

/**
 * 内容工厂
 *
 * 创建内容类型，保存内容类型变量
 *
 * @package		asonwebcms
 * @author		nick <authen@qq.com>
 */
class Contentfactory{

	static $types;
	public $ci;
	//public $type;
	
	function __construct(){
		$this->ci = & get_instance();
		self::$types = $this->ci->config->item('types');
	}
	
	//所有类型
	public static function get_type($name){
		if( isset($name) ){
			return self::$types[$name];
		}
		else return self::$types;
	}
	
	/* function __get($type){
		return $this->type;
	}
	
	function __set($type){
		$this->type = $type;
	} */
	
}