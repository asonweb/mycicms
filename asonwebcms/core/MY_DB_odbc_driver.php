<?php

/*
 * -------------------------------------------------------------------
 * 扩展 odbc驱动，适配 access 数据库
 * -------------------------------------------------------------------
 */

class MY_DB_odbc_driver extends CI_DB_odbc_driver{
	
	// clause and character used for LIKE escape sequences
	var $_like_escape_str = '';
	var $_like_escape_chr = '';
	// --------------------------------------------------------------------
	
	/**
	 * Insert ID
	 *
	 * @access	public
	 * @return	integer
	 */
	function insert_id()
	{
		if (DBTYPE =='access') {
			$result = $this->query( "SELECT @@IDENTITY as insert_id" );
			$insert_id = array_shift($result->result_array());
			return $insert_id['insert_id'];
		}
	}
	
	
	/**
	 * Affected Rows
	 *
	 * @access	public
	 * @return	integer
	 */
	function affected_rows()
	{
		return @odbc_num_rows($this->conn_id);
	}
	
	/**
	 * 加载数据结果驱动类
	 * 
	 *
	 * @param
	 * @return void
	 */
	public function load_rdriver()
	{
		$driver = 'MY_DB_odbc_result';
	
		if ( ! class_exists($driver))
		{
			include_once(BASEPATH.'database/DB_result'.EXT);
			include_once(BASEPATH.'database/drivers/'.$this->dbdriver.'/'.$this->dbdriver.'_result.php');
			include_once(APPPATH.'core/MY_DB_odbc_result'.EXT);
		}
	
		return $driver;
	}
	
	/**
	 * 适配access sql
	 * sql:select id,name from table;
	 * 返回sql: select top $limit id,name from table
	 * @param
	 * @return void
	 */
	function _limit($sql, $limit, $offset)
	{
		
		// Does ODBC doesn't use the LIMIT clause?
		return preg_replace('/select/i', 'select top '.$limit, $sql) ;
	}
	
}