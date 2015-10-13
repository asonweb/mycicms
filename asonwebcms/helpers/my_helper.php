<?php

if (! function_exists('theme_url')) {
	function theme_url() {
		$ci = & get_instance();
		return base_url().Theme::get_theme_path();
	};
}

function theme_path(){
	return ROOTPATH.Theme::get_theme_path().'views/';
}

// 自动转换字符集 支持数组转换
function auto_charset(&$fContents, $from='gbk', $to='utf-8') {
	$from = strtoupper($from) == 'UTF8' ? 'utf-8' : $from;
	$to = strtoupper($to) == 'UTF8' ? 'utf-8' : $to;
	if (strtoupper($from) === strtoupper($to) || empty($fContents) || (is_scalar($fContents) && !is_string($fContents))) {
		//如果编码相同或者非字符串标量则不转换
		return $fContents;
	}
	if (is_string($fContents)) {
		if (function_exists('mb_convert_encoding')) {
			return mb_convert_encoding($fContents, $to, $from);
		} elseif (function_exists('iconv')) {
			return iconv($from, $to, $fContents);
		} else {
			return $fContents;
		}
	} elseif (is_array($fContents)) {
		foreach ($fContents as $key => $val) {
			$_key = auto_charset($key, $from, $to);
			$fContents[$_key] = auto_charset($val, $from, $to);
			if ($key != $_key)
				unset($fContents[$key]);
		}

		return $fContents;
	}
	else {
		return $fContents;
	}
}

function no_result($html,$echo=true){
	if ($echo) echo $html;
	else return $html;
}

if (! function_exists('get_category')) {
	function get_category($id){
		$ci = & get_instance();
		return $ci->category_model->get_category_array($id);
	}
}

if (! function_exists('get_categories')) {
	function get_categories($options){
		$ci = & get_instance();
		$ci->load->model('category_model');
		return $ci->category_model->lists($options);
	}
}

function get_contents($options=''){
	$ci = & get_instance();
	$ci->load->model('content_model');
	return $ci->content_model->lists($options);
}

function get_content($id){
	$ci = & get_instance();
	return $ci->db->get_where('contents',array('id'=>$id))->row_array();
}

function current_url_string($uri,$key=NULL,$val=NULL){
	parse_str($_SERVER['QUERY_STRING'],$input_get);
	if(isset($key)) $input_get[$key] = $val;
	return $uri.'?'.http_build_query($input_get);
}


