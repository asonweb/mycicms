<?php

class Position extends AdminController{
	
	public $count;
	public $positions;
	
	function __construct(){
		parent::__construct();
		$this->config->load('position');
		$this->positions = $this->config->item('position');
		end($this->positions );
		$this->count = key($this->positions);
		//file helper
		$this->load->helper('file');
	}
	
	function add_position(){
		$name = $this->input->post('name');
		if( !$name)	Displayview::display('content_position/add_position',$this->data); return ;
		if($name){
			if( in_array($name, $this->positions)) return ;
			$this->count++;
			$this->positions[$this->count] = $name;
			write_file(ROOTPATH.'config/position.php', "<?php \$config['position']=".var_export(  $this->positions,true).";" );
		}
		redirect('admin/position/list_positions');
	}
	
	function edit_position($id){
		$this->data['name'] = $this->positions[$id];
		$this->data['id'] = $id;
		Displayview::display('content_position/edit_position', $this->data);
	}
	
	function update_position($id){
		$name = $this->input->post('name');
		//是否存在名称
		if( !in_array( $name, $this->positions) ) {
			$this->positions[$id] = $name;
			write_file(ROOTPATH.'config/position.php', "<?php \$config['position']=".var_export(  $this->positions,true).";" );
			redirect('admin/position/list_positions');
		}
		
		$this->data['msg'] = array('type'=>0,'msg'=>$name.'名称已存在');
		$this->data['id'] = $id;
		$this->data['name'] = $name;
		Displayview::display('content_position/edit_position', $this->data);
	}
	
	function list_positions(){
		$this->data['lists'] = $this->positions;
		Displayview::display('content_position/list_positions',$this->data);
	}
	
	function delete_position($id){
		unset($this->positions[$id]);
		write_file(ROOTPATH.'config/position.php', "<?php \$config['position']=".var_export(  $this->positions,true).";" );
		redirect('admin/position/list_positions');
	}
	
}