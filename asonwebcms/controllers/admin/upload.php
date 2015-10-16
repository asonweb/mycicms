<?php
/**
 * 上传图片
 * 
 *
 * @param
 */
class Upload extends AdminController{
	
	function __construct(){
		parent::__construct();
	}
	
	function many($content_type,$catid=NULL){
		$this->load->library('tree');
		$this->load->model('category_model');
		$this->tree->init($this->category_model->lists('type='.$content_type));
		if( isset($catid) )
			$this->data['categories'] = $this->tree->get_tree_select(0,"<option value=\$id \$selected>\$spacer\$name</option>", $catid);
		else 
			$this->data['categories'] = $this->tree->get_tree_select(0,"<option value=\$id \$selected>\$spacer\$name</option>", 0);
		Displayview::display('content/uploadmany',$this->data);
	}

	/**
	 * Upload files
	 */
	public function doupload($type)
	{
		$config['upload_path'] = './uploads/';	//上传保存目录
		$config['allowed_types'] = 'gif|jpg|png';	//允许上传类型
		$config['max_size'] = '500';	//最大文件大小 500k
		$config['encrypt_name'] = TRUE;	//编码名称
	
		$this->load->library('upload', $config);
	
		if( ! $this->upload->do_upload('file') )	//表单字段名称
		{
			echo json_encode(
					array(
							"state" => $this->upload->display_errors(),	//输出json和前端接口保持一致
					)
			);
		}else{
			$upload_result =  $this->upload->data();
			$filename = $upload_result['raw_name'].$upload_result['file_ext'];
				
			$data['name'] = $upload_result['orig_name'];
			$data['filename'] = $upload_result['file_name'];
			$data['filesize'] = $upload_result['file_size'];
			$data['extension'] = $upload_result['file_ext'];
			$data['path'] = substr($config['upload_path'], 1).$upload_result['file_name'];
			$data['description'] = '';
			
			$content['title'] = str_replace($data['extension'], '', $data['name']);
			if($this->input->post('catid')) $content['catid'] = $this->input->post('catid');
			var_dump($this->input->post());
			$content['createtime'] = time();
			$content['status'] = 1;
			$content['thumb'] = $data['path'];
			$content['typeid'] = 1;	//暂时支持只需要支持产品类型
				
			$this->load->model('content_model');
			$insert_id = $this->content_model->insert($content);
			
			if($insert_id!=false){
				//输出json和前端接口保持一致
				echo json_encode(
						array(
								"state" => 'SUCCESS',
								"url" => substr($config['upload_path'], 1).$upload_result['file_name'],	//放在根目录下
								"title" => $upload_result['file_name'],
								"original" => $upload_result['orig_name'],
								"type" => $upload_result['file_type'],
								"size" => $upload_result['file_size'],
								"file_id"=> (int)$insert_id,
						)
				);
			}
		}
	}
	
	
	protected function create_thumb($src,$belongto){
		//create a thumbnail
		$config['image_library'] = 'gd2';
		$config['source_image']	= "./uploads/$src";
		$config['create_thumb'] = false;
		$config['maintain_ratio'] = TRUE;
		$config['width']	= 300;
		$config['height']	= 300;
	
		$this->load->library('image_lib', $config);
	
		$this->image_lib->resize();
	}
}