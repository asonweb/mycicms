<?php

class MY_DB_odbc_result extends CI_DB_odbc_result{
	
	/**
	 * 查询记录的行数
	 * 重写原来的，适配access数据库
	 * 
	 * 直接完成转码
	 *
	 * @param
	 * @return int 
	 */
	function num_rows(){
		if ( count($this->result_array) > 0 ) {
			return count( $this->result_array );
		}
		
		while ( $row = $this->_fetch_assoc() )
		{
			$this->result_array[] = $row;
		}

		return empty($this->result_array) ? 0 : count( $this->result_array ) ;
	}
	
	/**
	 * 表的字段列表
	 *
	 * 生成一个表字段列名称的数组，修复默认 CI_DB_odbc_result->list_fields()的错误
	 *
	 * @access	public
	 * @return	array
	 */
	function list_fields()
	{
		$field_names = array();
		for ($i = 1; $i <= $this->num_fields(); $i++)
		{
		$field_names[]	= odbc_field_name($this->result_id, $i);
		}
	
		return $field_names;
	}
	
	/**
	 * Query result.  "array" version.
	 *
	 * @access	public
	 * @return	array
	 */
	public function result_array($offset=false,$pagesize=0)
	{
		if ( $offset !== false ){
			$this->result_array = array();
			$this->result_access( $offset, $pagesize);
		}
		
		if (count($this->result_array) > 0)
		{
			return $this->result_array;
		}
	
		// In the event that query caching is on the result_id variable
		// will return FALSE since there isn't a valid SQL resource so
		// we'll simply return an empty array.
		if ($this->result_id === FALSE OR $this->num_rows() == 0)
		{
			return array();
		}
	
		$this->_data_seek(0);

		while ($row = $this->_fetch_assoc())
		{
			$this->result_array[] = $row;
		}
	
		return $this->result_array;
	}
	
	/**
	 * access不支持limit,所以自写方法完成
	 * 获取所有记录
	 * odbc_fetch_row 让游标偏移 $offset
	 *
	 * @param int $offset	游标偏移量
	 * @param int $pagesize	查询的结果行数
	 * @return array
	 */
	function result_access( $offset, $pagesize = 0 )
	{
		odbc_fetch_row ( $this->result_id, $offset );
		$i=1;
		while ( $row = $this->_fetch_assoc()){
			if ($i <= $pagesize) $this->result_array[] = $row ; $i++;
		}
	}
	
	/**
	 * Result - associative array
	 *
	 * Returns the result set as an array
	 *
	 * @param bool $charset 是否转码 默认转码，gbk to utf-8;
	 * @access	private
	 * @return	array
	 */
	function _fetch_assoc( $charset=true )
	{
	
		if (function_exists('odbc_fetch_object'))
		{	
			return auto_charset( odbc_fetch_array($this->result_id) );
		}
		else
		{
			return auto_charset( $this->_odbc_fetch_array($this->result_id) );
		}
	}
}