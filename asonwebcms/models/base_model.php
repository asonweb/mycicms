<?php

class Base_model extends CI_Model{
	
	//数据表
	public $table;
	
	//主键名
	public $pk;
	
	//语言表
	public $lang_table;
	
	//扩展字段
	public $extend_fields;
	
	protected $_languages = array();
	
	public $fields = array();
	
	protected static $publish_filter = TRUE;
	
	protected $validate = array();
	protected $skip_validation = FALSE;
	
	public $protected_attributes = array( 'id');
	
	function __construct(){
		parent::__construct();
	}
	
	/*
	 * -------------------------------------------------------------------
	 * 设置当前的表名
	 * -------------------------------------------------------------------
	 */
	public function set_table($table){
		$this->table = $table;
	}
	
	public function set_pk($pk)
	{
		$this->pk = $pk;
	}
	
	/**
	 * 创建新字段
	 * 
	 *
	 * @param
	 * @return void
	 */
	public function insert($data, $skip_validation = FALSE){
		if ($skip_validation === FALSE)
		{
			$data = $this->validate($data);
		}
		
		if ($data !== FALSE)
		{
			
			$this->before_create($data);
			$this->db->insert($this->table, $data);
			$insert_id = $this->db->insert_id();
			
			$this->after_create();
			return $insert_id;
		}
		else
		{
			return FALSE;
		}
	}
	
	/**
     * 根据主键来更新
     */
    public function update($primary_value, $data, $skip_validation = FALSE)
    {
    	
        $data = $this->clean_data($data);
        
    	$this->before_update($data);

        if ($skip_validation === FALSE)
        {
            $data = $this->validate($data);
        }

        if ($data !== FALSE)
        {
        	
            $result = $this->db->where($this->pk, intval( $primary_value ) )
                               ->set($data)
                               ->update($this->table);

            $this->after_update();

            return $result;
        }
        else
        {
            return FALSE;
        }
    }

    //通过 id来删除
	public function delete($id){
		$this->db->where($this->pk, $id);
		$result = $this->db->delete($this->table);
		return $result;
	}
	
	/*
	 * 获取一条记录
	 */
	public function get($id)
	{
		$find = $this->get_by( $this->pk, intval( $id ) );
		return $find;
	}
	
	/**
	 * Fetch a single record based on an arbitrary WHERE call. Can be
	 * any valid value to $this->_database->where().
	 */
	public function get_by()
	{
		$where = func_get_args();

		$this->_set_where($where);

		$row = $this->db->get($this->table)
		->row_array();
		
		$this->after_get($row);
		
		return $row;
	}
	
	/**
	 * Set WHERE parameters, cleverly
	 * 
	 * @param $params	array('field =1','2','3');
	 */
	protected function _set_where($params)
	{
		//array( 'field_key' => array('1','2','3') )
		if (count($params) == 1 && is_array($params[0]))
		{
			foreach ($params[0] as $field => $filter)
			{
				if (is_array($filter))
				{
					$this->db->where_in($field, $filter);
				}
				else
				{
					if (is_int($field))
					{
						$this->db->where($filter);
					}
					else
					{
						$this->db->where($field, $filter);
					}
				}
			}
		}
		else if (count($params) == 1)//数组只有1个值,比如 array('catid=2')
		{
			$this->db->where($params[0]);
		}
		else if(count($params) == 2)	//
		{
			if (is_array($params[1]))	//比如 array( 'field_key',array('1','2','3') )
			{
				$this->db->where_in($params[0], $params[1]);
			}
			else
			{
				$this->db->where($params[0], $params[1]);	//比如 array( 'field_key!=',3 ) //array( 'field_key>',3 )
			}
		}
		else if(count($params) == 3)
		{
			$this->db->where($params[0], $params[1], $params[2]);
		}
		else
		{
			if (is_array($params[1]))
			{
				$this->db->where_in($params[0], $params[1]);
			}
			else
			{
				$this->db->where($params[0], $params[1]);
			}
		}
	}
	
	/**
	 * Fetch all the records in the table. Can be used as a generic call
	 * to $this->_database->get() with scoped methods.
	 */
	public function get_all()
	{
		$result = $this->db->get($this->table)
		->result_array();
	
		foreach ($result as $key => &$row)
		{
			$row = $this->after_get($row);
		}
		return $result;
	}
	
	/**
	 * Fetch an array of records based on an arbitrary WHERE call.
	 */
	public function get_lists_by()
	{
		$where = func_get_args();
	
		if ( $where ) $this->_set_where($where);
	
		return $this->get_all();
	}
	
	/**
	 * 包装 $this->db()方法
	 */
	public function limit($limit, $offset = 0)
	{
		$this->db->limit($limit, $offset);
		return $this;
	}
	
	/**
	 * 包装 $this->_database->order_by()
	 */
	public function order_by($criteria, $order = 'ASC')
	{
		if ( is_array($criteria) )
		{
			foreach ($criteria as $key => $value)
			{
				$this->db->order_by($key, $value);
			}
		}
		else
		{
			$this->db->order_by($criteria, $order);
		}
		return $this;
	}
	
	/**
	 * 自动验证
	 * 包装 验证，不用一个一个去验证了
	 * 
	 * 
	 * @return array $data	(不验证 或 验证成功 ) 
	 * bool false	需要验证,如果失败
	 * 
	 */
	public function validate($data)
	{
		if($this->skip_validation)
		{
			return $data;
		}
	
		if(!empty($this->validate))
		{
			foreach($data as $key => $val)
			{
				//重新赋值
				$this->before_get($val);
				$_POST[$key] = $val;
			}
			
			$this->load->library('form_validation');
	
			if(is_array($this->validate))
			{
				$this->form_validation->set_rules($this->validate);
	
				if ($this->form_validation->run() === TRUE)
				{
					return $data;
				}
				else
				{
					return FALSE;
				}
			}
			else
			{
				if ($this->form_validation->run($this->validate) === TRUE)
				{
					return $data;
				}
				else
				{
					return FALSE;
				}
			}
		}
		else
		{
			return $data;
		}
	}
	
	/**
	 * Removes from the data array the index which are not in the table
	 *
	 * @param      $data		The data array to clean
	 * @param bool $table		Reference table. $this->table if not set.
	 *
	 * @return array
	 */
	public function clean_data($data, $table = FALSE)
	{
		$cleaned_data = array();
	
		if ( ! empty($data))
		{
			$table = ($table !== FALSE) ? $table : $this->table;
	
			$fields = $this->list_fields($table);
			
			$fields = array_fill_keys($fields,'');
			
			$cleaned_data = array_intersect_key($data, $fields);
		}
		
		foreach($cleaned_data as $key=>$row)
		{
			if (is_array($row))
				unset($cleaned_data[$key]);
		}
		
		return $cleaned_data;
	}
	
	public function list_fields($table = '')
	{
		$table = ( $table != '' ) ? $this->table :  $table;

		if (!empty($this->fields))
			return $this->fields;
		
		$this->fields = $this->db->limit(1)->get($this->table)->list_fields();
	
		return $this->fields;
	}
	
	/**
	 * Trigger an event and call its observers. Pass through the event name
	 * (which looks for an instance variable $this->event_name), an array of
	 * parameters to pass through and an optional 'last in interation' boolean
	 */
	public function trigger($event, $data = FALSE, $last = TRUE)
	{
		if (isset($this->$event) && is_array($this->$event))
		{
			foreach ($this->$event as $method)
			{
				if (strpos($method, '('))
				{
					preg_match('/([a-zA-Z0-9\_\-]+)(\(([a-zA-Z0-9\_\-\., ]+)\))?/', $method, $matches);
	
					$method = $matches[1];
					$this->callback_parameters = explode(',', $matches[3]);
				}
	
				$data = call_user_func_array(array($this, $method), array($data, $last));
			}
		}
	
		return $data;
	}
	
	protected function before_create(&$data){
		//去掉自动编号的字段
		$this->protect_attributes($data);
		//access 编码gbk，插入前转码
		auto_charset($data,'utf-8','gbk');
	}
	
	protected function after_create(){
		
	}
	
	protected function before_update(&$data){
		//去掉自动编号的字段
		$this->protect_attributes($data);
		//access 编码gbk，更新前转码
		auto_charset($data,'utf-8','gbk');
		return $data;
	}
	
	protected function after_update(){
		
	}
	
	protected function after_get(&$data){
		return $data;
	}
	
	protected function before_get(&$data){
		
	}
	
	/**
	 * Protect attributes by removing them from $row array
	 */
	public function protect_attributes(&$data)
	{
		foreach ($this->protected_attributes as $attr)
		{
			unset($data[$attr]);
		}
	
		return $data;
	}
	
	/**
	 * Fetch a count of rows based on an arbitrary WHERE call.
	 */
	public function count_by()
	{
		$where = func_get_args();
		if ( !empty($where) ) $this->_set_where($where);	//$where存在参数
	
		return $this->db->count_all_results();
	}
	
	/**
	 * Fetch a total count of rows, disregarding any previous conditions
	 */
	public function count_all()
	{
		return $this->db->count_all();
	}
	
}