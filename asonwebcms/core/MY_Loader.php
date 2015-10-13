<?php

require_once 'Theme.php';

class MY_Loader extends CI_Loader{
	
	/**
	 * Since parent::_ci_view_paths is protected we use this setter to allow
	 * things like plugins to set a view location.
	 *
	 * @param string $path
	 */
	public function set_view_path($path)
	{
		if (is_array($path))
		{
			// if we're restoring saved paths we'll do them all
			$this->_ci_view_paths = $path;
		}
		else
		{
			// otherwise we'll just add the specified one
			$this->_ci_view_paths = array($path => true);
		}
	}
	
	/**
	 * Since parent::_ci_view_paths is protected we use this to retrieve them.
	 *
	 * @return array
	 */
	public function get_view_paths()
	{
		// return the full array of paths
		return $this->_ci_view_paths;
	}
	
	public function view($view, $vars = array(), $return = FALSE){
		list($path,$view) = Theme::find_view($view);
		$this->_ci_view_paths = array($path=>true);
		return $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_object_to_array($vars), '_ci_return' => $return));
	}
	
	/** Load the database drivers **/
	public function database($params = '', $return = FALSE, $active_record = NULL) {
		
		// Grab the super object
		$CI =& get_instance();
		
		if (class_exists('CI_DB', FALSE) AND $return == FALSE AND $active_record == NULL)
			return;
	
		require_once BASEPATH.'database/DB'.EXT;
	
		$db = DB($params, $active_record);
	
		$my_driver = 'MY_DB_'.$db->dbdriver.'_driver';
		$my_driver_file = APPPATH.'core/'.$my_driver.EXT;
		
		if (file_exists($my_driver_file))
		{
			require_once($my_driver_file);
			$db = new $my_driver(get_object_vars($db));
		}
		
		if ($return === TRUE)
		{
			return $db;
		}
		// Initialize the db variable.  Needed to prevent
		// reference errors with some configurations
		$CI->db = '';

		// Load the DB class
		$CI->db = $db;
	}
	
	/**
	 * Loads a config file
	 *
	 * @param	string
	 * @param	bool
	 * @param 	bool
	 * @return	void
	 */
	public function config($file = '', $use_sections = FALSE, $fail_gracefully = FALSE)
	{
		$CI =& get_instance();
		$CI->config->load($file, $use_sections, $fail_gracefully);
	}
}