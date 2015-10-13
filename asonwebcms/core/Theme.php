<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 */

// ------------------------------------------------------------------------


/**
 * 模板主题类
 *
 * 
 * @package		asonweb
 * @subpackage	Librairies
 * @category	Librairies
 * @author		nick <authen@qq.com>
 */
 
class Theme {
	
	// Themes base folder. All themes are stored in this folder in their own folder
	private static $theme_base_path = 'themes/';
	
	// Views folder
	private static $views_folder = 'views/';
	
	// Current theme folder.
	private static $theme = '';
	
	
	// ------------------------------------------------------------------------
	
	
	/** 
	 * Sets the theme
	 *
	 * @access	public
	 * @param	string	The theme folder
	 */ 
	public static function set_theme($t)
	{
		self::$theme = $t;
	}
	
	
	// ------------------------------------------------------------------------
	
	
	/**
	 * Returns the theme name
	 *
	 */
	public static function get_theme()
	{
		return self::$theme;		
	}
	
	
	// ------------------------------------------------------------------------
	
	
	/**
	 * Returns the complete path to the theme
	 *
	 */
	public static function get_theme_path()
	{
		return self::$theme_base_path.self::$theme.'/';		
	}
	
	
	// ------------------------------------------------------------------------
	
	
	/**
	 * Loads a view as a string
	 * Used by Base_Controller->render() method to load a view
	 *
	 * @param	string	View name to load
	 * @param	sring	Directory where is the view
	 *
	 * @return	string	The load view
	 *
	 */
	public static function load($name, $directory = 'views')
	{
		$file = self::find_view($name, $directory, true);

		if(empty($file))
		{
			show_error('Theme error : <b>The file "'.$directory.'/'.$name.'" cannot be found.</b>');
		}
		
		$string = file_get_contents(array_shift($file));
		
		return $string;
	}
	
	
	// ------------------------------------------------------------------------
	
	
	/**
	 * Try to get the default view
	 * The view must be named "page.php", "article.php" etc.
	 *
	 * @return	String 	The relative path to the default page view
	 *
	 */
	public static function get_default_view($type)
	{
		if (isset(self::$default_views[$type]))
		{
			foreach(self::$default_views[$type] as $view)
			{
				if (file_exists(BASEPATH.'../'.self::get_theme_path().self::$views_folder.$view.EXT))
				{
					return $view;
				}
			}
		}
		// Returns the first page view as real default.
		return self::$default_views[$type][0];
	}
	
	
	// ------------------------------------------------------------------------
	
	
	/**
	 * Outputs one view
	 *
	 * @access	public
	 * @param	string	Name of the view
	 * @param	array	View's data array
	 *
	 */
	public function output($view, $data)
	{
		$ci =  &get_instance();
		
		// Loads the view
		$output = $ci->load->view($view, $data, true);
		
		// Set character encoding
		$ci->output->set_header("Content-Type: text/html; charset=UTF-8");
		
		$ci->output->set_output($output);
	}
	
	
	public static function find_view($file) {

		$segments = explode('/', $file);
		
		//带后缀的文件名   $file_ext相对的路径
		$file = array_pop($segments);
		$file_ext = strpos($file, '.') ? $file : $file.EXT;
		
		$path = ltrim(implode('/', $segments).'/', '/');
		//var_dump(APPPATH);exit();
		
		if (file_exists( ROOTPATH . self::get_theme_path().self::$views_folder .$path. $file_ext )) {
			return array(ROOTPATH.self::get_theme_path().self::$views_folder.$path, $file);
		}
		
		if (file_exists( APPPATH . self::get_theme_path().self::$views_folder .$path. $file_ext )) {
			return array( APPPATH.self::get_theme_path().self::$views_folder.$path, $file);
		}
		
		show_error("Unable to locate the file: {$path}{$file_ext}");
		return array(FALSE, $file);
	}
	

}


/* End of file Theme.php */
/* Location: ./application/libraries/Theme.php */