<?php

class User extends HomeController{
	
	protected $authen;
	protected $table = 'users';
	
	function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->model('user_model','users');
		
		if( $this->session->userdata('admin') or $this->session->userdata('user')) $this->authen = true;
	}
	
		
	function index(){
		$this->data['head'] = $this->parser->parse('home/head-page',$this->pagedata,true);
		$this->data['header'] = $this->parser->parse('home/header.html',$this->pagedata,true);
		$this->data['footer'] = $this->parser->parse('home/footer.html',$this->pagedata,true);
		$user = $this->session->userdata('user');
		$user =$user[0];
		
		$orders = $this->listsall($user['id']);
		if ($this->session->userdata('user') ==null) {
			$this->data['component'] = $this->parser->parse('home/components/user/order',array(),true);
		}else{
			$this->data['component'] = $this->parser->parse('home/components/user/order',$orders,true);
		}
		
		//authen true, load index view
		$this->parser->parse('home/user',$this->data);
	}
	
	
	private function listsall($uid,$order=''){
		if (empty($order)) {
			$order = 'order_time desc';
		}
		
		$count = $this->db
		->order_by($order)
		->where('uid',$uid)
		->get('order');
		$count = $count->result_array();
		
		if (count($count) > 0) {
			//分页 1.load 分页类，2.加载分页配置，
			$this->load->library('pagination');
			$this->config->load('pagination');
			$pageconfig = $this->config->item('pagination');
		
			$pageconfig['total_rows'] = count($count);
			$pageconfig['base_url'] = site_url('user/index');
		
			if (count($count) < $pageconfig['per_page'] ){
				auto_charset($count);
				return array('lists'=>$count);
			}
		
			$offset = $pageconfig['per_page'] * ($this->uri->segment(3,1) -1);
		
			//return resource object
		
			$query = $this->db->_execute("select * from as_".$this->table . "where uid=$uid order by ".$order);
			$lists = $this->db->limit_access($query,$offset,$pageconfig['per_page']);
			$pages = $this->paged($pageconfig);
			$lists = auto_charset($lists);
		
			$r = array('lists'=>$lists,'pages'=>$pages);
			return $r;
		}else{
			return null;
		}
	}
	/*
	 * 登录
	 * 登陆页url get
	 * 登陆页submit post
	 */
	function login(){
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('user_name', '用户名', 'trim|required|min_length[4]|max_length[10]');
		$this->form_validation->set_rules('user_pass', '密码', 'required|min_length[6]|max_length[12]');
		
		$this->data['head'] = $this->parser->parse('home/head-page',$this->pagedata,true);
		$this->data['header'] = $this->parser->parse('home/header.html',$this->pagedata,true);
		$this->data['footer'] = $this->parser->parse('home/footer.html',$this->pagedata,true);
			
		$this->data['component'] = $this->parser->parse('home/components/user/login',array(),true);
		
		if ( $this->form_validation->run() !== false ) {
			$authen = $this->users->authen();
			if ($authen !==false) {
				unset($authen['user_pass']);
				$this->session->set_userdata('user',$authen);
				redirect('user/index');
			}
			$this->session->set_flashdata('message','账号或密码错误');
		}
		$this->parser->parse('home/user',$this->data);
	}
	
	/*
	 * 注册
	 * @return
	 * load view
	 */
	function register(){
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div>', '</div>');
		$this->form_validation->set_rules('user_login', '会员名称', 'trim|required|min_length[4]|max_length[10]');
		$this->form_validation->set_rules('user_pass', '密码', 'required|min_length[6]|max_length[12]|md5');
		$this->form_validation->set_rules('pass_confirm', '密码确认', 'required|matches[user_pass]');
		$this->form_validation->set_rules('user_sex', '性别', 'required');
		$this->form_validation->set_rules('user_phone', '手机号码', 'required');
		$this->form_validation->set_rules('user_qq', 'QQ','trim');
		$this->form_validation->set_rules('user_email', '邮箱','trim|valid_email');
		
		if ($this->form_validation->run() === false) {
			$this->data['head'] = $this->parser->parse('home/head-page',$this->pagedata,true);
			$this->data['header'] = $this->parser->parse('home/header.html',$this->pagedata,true);
			$this->data['footer'] = $this->parser->parse('home/footer.html',$this->pagedata,true);
			
			$this->data['component'] = $this->parser->parse('home/components/user/register',array(),true);
			$this->parser->parse('home/user',$this->data);
			
		}else{
			
			$user['user_login'] = $this->input->post('user_login');
			$user['user_pass'] = $this->input->post('user_pass');
			$user['user_sex'] = $this->input->post('user_sex');
			
			$user['user_email'] = $this->input->post('user_mail');
			$user['user_mobile'] = $this->input->post('user_phone');
			
			$user['user_qq'] = $this->input->post('user_qq');
			
			$id = $this->user_model->save($user);
			$this->session->userdata('user',$user);
			//redirect('user/index');
		}
		
		
	}

	/*
	 * 退出
	 */
	function loginout(){
		$this->session->set_flashdata('message','您已安全退出');
		$this->session->unset_userdata('user');
		$this->generateCookie('[]', time()-3600);
		redirect('user/login');
	}
	
	
	private function generateCookie($data, $expire)
	{
		setcookie('user', $data, $expire, '/', $_SERVER['HTTP_HOST']);
	}
	
	/* function login($email, $password, $remember=false)
	{
		$this->db->select('*');
		$this->db->where('email', $email);
		$this->db->where('active', 1);
		$this->db->where('password',  sha1($password));
		$this->db->limit(1);
		$result = $this->db->get('customers');
		$customer   = $result->row_array();
	
		if ($customer)
		{
	
			// Retrieve customer addresses
			$this->db->where(array('customer_id'=>$customer['id'], 'id'=>$customer['default_billing_address']));
			$address = $this->db->get('customers_address_bank')->row_array();
			if($address)
			{
				$fields = unserialize($address['field_data']);
				$customer['bill_address'] = $fields;
				$customer['bill_address']['id'] = $address['id']; // save the addres id for future reference
			}
	
			$this->db->where(array('customer_id'=>$customer['id'], 'id'=>$customer['default_shipping_address']));
			$address = $this->db->get('customers_address_bank')->row_array();
			if($address)
			{
				$fields = unserialize($address['field_data']);
				$customer['ship_address'] = $fields;
				$customer['ship_address']['id'] = $address['id'];
			} else {
				$customer['ship_to_bill_address'] = 'true';
			}
	
	
			// Set up any group discount
			if($customer['group_id']!=0)
			{
				$group = $this->get_group($customer['group_id']);
				if($group) // group might not exist
				{
					$customer['group'] = $group;
				}
			}
	
			if($remember)
			{
				$loginCred = json_encode(array('email'=>$email, 'password'=>$password));
				$loginCred = base64_encode($this->aes256Encrypt($loginCred));
				//remember the user for 6 months
				$this->generateCookie($loginCred, strtotime('+6 months'));
			}
	
			// put our customer in the cart
			$this->go_cart->save_customer($customer);
	
	
			return true;
		}
		else
		{
			return false;
		}
	} */
	
}