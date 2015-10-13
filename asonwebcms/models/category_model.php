<?php

Class Category_model extends Base_model
{
	public $table ='categories';
	
	public $pk ='id';
	
	public $categories;
	
	function __construct(){
		parent::__construct();
		$this->load->library( array('tree','contentfactory') );
		$this->load->helper('file');	//引入file帮助函数文件，用于写入或生成配置文件
		
		//分类保存到文件，有文件存在直接加载 保存在内存
		if ($this->config->load('cache_categories', false, true)) {
			$this->categories = $this->config->item('categories');
		}else{
			$this->categories = $this->lists('fetch=id');
			write_file(ROOTPATH.'config/cache_categories.php', "<?php  \$config['".$this->table."'] = ".var_export( $this->categories,true).";" );
		}
	}
	
	protected function reset_cache(){
		//分类保存到文件，有文件存在直接加载 保存在内存
		$items = $this->lists('fetch=id');
		$this->categories = $this->lists('fetch=id');
			write_file(ROOTPATH.'config/cache_categories.php', "<?php  \$config['".$this->table."'] = ".var_export( $items,true).";" );
	}
	
	protected function after_delete(){
		$this->reset_cache();
	}
	
	protected function after_create(){
		$this->reset_cache();
	}
	protected function after_update(){
		$this->reset_cache();
	}
	/*
	 * 获取所有分类
	 * @param $pid
	 * @param $fetch
	 * 0   以0开始索引的数组
	 * 'id' 以列 id为索引的数组
	 * 
	 * @param string $options array $uri_to_assoc
	 * @return array
	 */
	function lists($options=null){
		
		if( !isset($options) ) $options = $this->uri->ruri_to_assoc();
		
		if( is_string($options) )
		{
			parse_str($options,$where);
			extract($where);
		}else
		{
			extract($options);
		}

		if( isset( $type ) )
		{
			$this->db->where('typeid', Contentfactory::$types[$type]['id']);
		}
		
		if( isset( $pid ) ) $this->db->where('pid', (int)$pid );	//pid字段 int类型
		
		if( isset( $order ) ) $this->db->order_by( $order );
		else $this->db->order_by('sort asc,create_time desc,id desc');
		
		//查询结果
		$result = $this->db->get('categories')->result_array();
		
		if( !isset( $fetch ))
		{
			return $result;
		}
		
		$result_key_id =  array();
		foreach ($result as $r)
		{
				$result_key_id[$r['id']] = $r;
		}
		return $result_key_id;
	}
    
    /*
     * 获取所有子分类数据
     * 1.如果递归，返回 所有下级子分类
     * 2.如果不递归，只查询  下级子分类
     * 
     * 
     * @param $pid 父类id
     * @param $cats 所有分类数据
     * @param $child 是否递归
     * @return 分类数据数组
     */
    function get_childids($pid,$child=true){
    	if ($child) {
    		$this->tree->init($this->categories);
    		return $this->tree->get_tree_array_ids($pid);
    	}else{
    		return $this->get_categories($pid);
    	}
    }
    
    
    /*
     * 一行分类
     * @params int $id
     * auto_charset gbk转 utf8
     * @return category object
     */
    function get_category($id)
    {
        return $this->categories[$id];
    }
    /*
     * 一行分类
    * @params int $id
    * auto_charset gbk转 utf8
    * @return array $row
    */
    function get_category_array($id)
    {
    	$row = $this->db->get_where('categories', array('id'=>intval($id) ))->row_array();
    	foreach ($row as $k=>$v)
    	{
    		$row[$k]= auto_charset($v);
    	}
    	return $row;
    }
    
    /*
     * 结合了 insert 和	update 操作
     * @param $category
     */
    function save($category)
    {
        if ($category['id'])
        {
        	$id = $category['id'];
        	unset($category['id']);
            $this->update((int)$id, $category);
            
            return $id;
        }
        else
        {
        	unset($category['id']);
        	$result = $this->insert($category);
            if ($result!==false) {
            	 return true;
            }else{
            	return false;
            }
        }
    }
    
    function delete($id)
    {
        $this->db->where('id', intval($id));
        $this->db->delete($this->table);
        //$this->db->where('category_id', $id);
        //$this->db->delete('category_products');
    }
}