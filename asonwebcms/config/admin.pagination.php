<?php


$config['pagination'] = array(
		'prefix' =>'',
		'per_page'=> 6,
		'base_url' => site_url('content/index'),
		'query_string_segment' => 'p',
		'use_page_numbers' => TRUE,
		'page_query_string' => true,
		'uri_segment'=> '5',
		'full_tag_open'=>'<ul class="pagination pagination-group">',
		'full_tag_close'=>'</ul>',
		'num_tag_open'=>'<li>',
		'num_tag_close'=>'</li>',
		'next_link' =>'下一页',
		'next_tag_open'=>'<ul class="pagination pagination-group"><li>',
		'next_tag_close'=>'</li></ul>',
		'prev_link' =>'上一页',
		'prev_tag_open'=>'<ul class="pagination pagination-group"><li>',
		'prev_tag_close'=>'</li></ul>',
		'cur_tag_open' =>'<li><a class="active">',
		'cur_tag_close' =>'</a></li>',
		'first_link'=>'第一页',
		'first_tag_open' => 	'<li>',
		'first_tag_close' => 	'</li>',
		'last_link'=>'最后页',
		'last_tag_open' => 		'<li>',
		'last_tag_close' => 	'</li>',
);


