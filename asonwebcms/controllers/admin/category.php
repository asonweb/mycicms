<?php

class Category extends AdminController{
	
	//$this->input->get(),ruri_to_assoc(),不包括post
	public $current;
	
	function __construct(){
		parent::__construct();
		$this->load->model('category_model');
		$this->load->helper('form');
		//将类型传递到视图
		$this->current = $this->uri->ruri_to_assoc();
		if( $this->input->get() ) { $this->current += $this->input->get();}
		
		$this->data['name'] = Contentfactory::$types[$this->current['type']];
	}
	
	/**
	 * 查询浏览
	 * 
	 *
	 * @param
	 */
	public function index(){
		
		$this->data['list_tables'] = $this->fetch_table();

		$this->data['body'] = $this->load->view('category/categories', $this->data , true);
		Displayview::display('category/category.html',$this->data);
	}
	
	protected function fetch_table(){
		$cats_tree = array();

		$cats = $this->category_model->lists();
		
		foreach ( $cats as $cat )
		{
			$cat['status'] = ( $cat['status'] == 1 ? '启用' : '禁用');
			
			$cat['add_sub_url'] = site_url('admin/category/parent/'.$this->data['name']['slugname'].'/'.$cat['id']);
			$cat['edit_url'] = site_url('admin/category/form/'.$this->data['name']['slugname'].'/'.$cat['id']);
			$cat['delete_url'] = site_url('admin/category/delete/'.$cat['id']);
			$cats_tree[] = $cat;
		}
		$str = "<tr>
				<td>\$id</td>
				<td>\$spacer\$name</td>
				<td><input type='text' name='sort[\$id]' value='\$sort' class='input input-auto' size='5' /></td>
				<td>\$status</td>
				<td>
					<div class='btn-group'>
<a class='button' href='\$add_sub_url'><i class='icon-pencil-square-o'></i> 添加子类</a>
						<a class='button' href='\$edit_url'><i class='icon-pencil'></i> 修改</a>
						<a class='button btn-danger' href='\$delete_url'><i class='icon-trash-o'></i> 删除</a>
					</div>
				</td>
			</tr>";
		$this->tree->init($cats_tree);
		$categorys = $this->tree->get_tree(0,$str,0,'');
		return $categorys;
	}
	
	function parent(){
		//视图有定义 $id
		$this->data['id']             = '';
		$this->data['pid'] = $this->current['pid'];
		
		//url_string 包含pid参数或影响分类结果，所以手动传参
		$this->tree->init($this->category_model->lists('type='.$this->current['type']));
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', '名称', 'trim|required|max_length[64]');
		
		// 存在分类，显示分类修改页面
		if ($this->form_validation->run() === FALSE)
		{
			$this->data['categories'] = $this->tree->get_tree_select(0,"<option value=\$id \$selected>\$spacer\$name</option>",intval($this->current['pid']));
			$this->data['catname'] = '';
			$this->data['content'] = '';
			$this->data['status'] = '1';
			$this->data['thumb'] = '';
			Displayview::display('category/category_form',$this->data);
		}else{
			$this->category_model->insert($this->input->post());
			redirect('admin/category/index/'.$this->current['type']);
		}
	}
	
	function delete($id)
    {
        $category   = $this->category_model->get_category(intval($id));
        if ($category)
        {
            $this->category_model->delete($id);
            $this->session->set_flashdata('message', '分类已经被删除');
            redirect($_SERVER['HTTP_REFERER']);
        }
        else
        {
            $this->session->set_flashdata('error', '分类没有找到');
        }
    }
	
    /**
     * 添加分类
     * 
     *
     * @param
     */
	function form()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		//分类 select options
		$this->tree->init($this->category_model->lists());
		
		$data['page_title']     = '分类表单';
	
		//default values are empty if the customer is new
		$this->data['id']             = '';
		$this->data['catname']           = '';
		$this->data['slug']           = '';
		$this->data['content']    = '';
		$this->data['excerpt']        = '';
		$this->data['sort']       = '';
		$this->data['thumb']          = '';
		$this->data['pid']      = 0;
		$this->data['status']        = '1';
		
	
		if ( isset( $this->current['id'] ) )
		{
			
			$category       = $this->category_model->get($this->current['id']);
	
			//如果分类不存在，返回到分类首页
			if (!$category)
			{
				$this->session->set_flashdata('error','没有找到分类');
				redirect('admin/category');
			}

			$this->data['id']             = $category['id'];
			$this->data['catname']          = $category['name'];
			$this->data['slug']           = $category['slug'];
			$this->data['content']    = $category['content'];
			$this->data['sort']       = $category['sort'];
			$this->data['pid']      = $category['pid'];
			$this->data['thumb']          = $category['thumb'];
			$this->data['status']        = $category['status'];
	
			$this->data['categories'] = $this->tree->get_tree_select(0,"<option value=\$id \$selected>\$spacer\$name</option>",$category['pid']);
		}

		$this->form_validation->set_rules('name', '名称', 'trim|required|max_length[64]');
	
		// 存在分类，显示分类修改页面
		if ($this->form_validation->run() === FALSE)
		{
			if( !isset( $this->current['id'] ) ){
				$this->data['categories'] = $this->tree->get_tree_select(0,"<option value=\$id \$selected>\$spacer\$name</option>",$this->input->post('pid') );
			}
			
			Displayview::display('category/category_form',$this->data);
		}
		else
		{
	
			//保存表单数据，应用于写入或更新数据
			
			$save['id']             = (int)$this->current['id'];
			$save['typeid']        = $this->input->post('typeid');
			$save['name']           = $this->input->post('name');
			$save['content']    = $this->input->post('content');
			$save['thumb']    = $this->input->post('thumb');
			$save['pid']      = intval($this->input->post('pid'));
			$save['sort']       = intval($this->input->post('sort'));
			$save['status']        = $this->input->post('status');
	
			$category_id    = $this->category_model->save($save);
			if ( $category_id!==false ) {
				$this->session->set_flashdata('msg','添加成功');
			}else{
				$this->session->set_flashdata('msg','添加失败');
			}

			//返回分类首页
			redirect('admin/category/index/'.$this->current['type']);
		}
	}
	
	function sort(){
		$ids = $this->input->post('sort');
		foreach($ids as $id=>$sort){
			$this->db->update('categories',array('sort'=>$sort),array('id'=>intval($id)));
		}
		redirect( $_SERVER['HTTP_REFERER']);
	}
	
}