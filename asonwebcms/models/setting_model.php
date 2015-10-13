<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Ionize, creative CMS Settings Model
 *
 * @package		Ionize
 * @subpackage	Models
 * @category	Settings
 * @author		Ionize Dev Team
 */
class Setting_Model extends Base_model
{
	/**
	 *
	 */
	public function __construct()
	{
		parent::__construct();

		$this->set_table('options');
		$this->set_pk('id');
		$ci = &get_instance();	//获取 CI 对象
		$ci->load->helper('file');	//引入file帮助函数文件，用于写入或生成配置文件
	}

	/**
	 * 根据名称来获取设置
	 * 
	 *
	 * @param $name 设置分组名称
	 * @return array();
	 */
	function get_setting( $name ){
		$result = $this->get_by( 'option_name', $name );
		if (isset($result['option_value'])) {
			return json_decode( $result['option_value'], true );
		}
		return array();
	}
	
	protected function after_update(){
		$this->reset_cache();
	}
	
	protected function reset_cache(){
		unlink(ROOTPATH.'config/setting.php');
		$this->setting_model->write_views_setting( array( 'site', 'contact', 'seo' ));
	}
	/**
	 * 查询数据库，自动生成配置文件，不用手动去代码了
	 * 
	 *
	 * @param array	$names 要获取的配置名称，也就是数据库的 options.option_name
	 * @param bool false 不写入新的配置，true 写入新的配置。
	 * @param string	$key 配置文件数组的键名, $this->config->item($key)就可以获取配置
	 * @param bool true 从数据库获取要写入的 false从代码直接写入。
	 * @return array $data
	 */
	function write_views_setting( $names = array(),$write_new = false, $key ='setting', $from_database =true ){
		//第三个参数引入配置文件失败的话，不报错，只是返回false
		if ( $this->config->load('setting', false, true) !=false and $write_new ==false ) return $this->config->item($key);
		
		$data = array();
		if(  $from_database ){
			foreach ( $names as $name ){
				$data = $data+$this->get_setting( $name );
			}
		}else{
			$data = $names;
		}
		
		if( $ori_config = read_file( ROOTPATH . 'config/setting.php' ) ){
			write_file(ROOTPATH.'config/setting.php', "$ori_config  \$config['".$key."'] = ".var_export( $data,true).";" );
		}else{
			write_file(ROOTPATH.'config/setting.php', "<?php  \$config['".$key."'] = ".var_export( $data,true).";" );
		}
		
		return $data;
	}
	
	
}