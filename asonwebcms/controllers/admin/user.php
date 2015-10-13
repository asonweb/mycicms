<?php


class User extends AdminController{
	
	function __construct(){
		parent::__construct();
		$this->load->model('users_model');
	}
	
	// redirect if needed, otherwise display the user list
	function index()
	{
		
		if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else
		{
			
			$this->data['groups_options'] = $this->ion_auth->groups_array('所有角色');
			
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			//list the users
			$this->data['users'] = $this->ion_auth->users()->result_array();
			foreach ($this->data['users'] as $k => $user)
			{
				$this->data['users'][$k]['groups'] = $this->ion_auth->get_users_groups($user['id'])->result_array();
			}

			$this->_render_page('index', $this->data);
		}
	}
	/**
	 * 筛选列表
	 * 
	 *
	 * @param
	 * @return void
	 */
	function lists(){
		$this->data['groups_options'] = $this->ion_auth->groups_array('所有角色');
		
		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		
		//list the users
		if( $this->input->post('email') ) $like['email'] = $this->input->post('email');
		if( $this->input->post('user_login') ) $like['user_login'] = $this->input->post('user_login');
		if( $this->input->post('pagesize') ) $limit = $this->input->post('pagesize') ;
		else $limit = 10;
		if( $this->input->post('role_id') ) $role = (int)$this->input->post('role_id');
		else $role = null;
		
		if( isset($like) ){
			$this->data['users'] = $this->ion_auth
			->like($like)
			->limit($limit)
			->users($role)->result_array();
		}else{
			$this->data['users'] = $this->ion_auth
			->limit($limit)
			->users($role)->result_array();
		}
		
		foreach ($this->data['users'] as $k => $user)
		{
			$this->data['users'][$k]['groups'] = $this->ion_auth->get_users_groups($user['id'])->result_array();
		}
		
		$this->_render_page('index', $this->data);
	}
	
	// create a new user
	function create_user()
	{
		$tables = $this->config->item('tables','ion_auth');
		// validate form input
		$this->form_validation->set_rules('user_login', $this->lang->line('create_user_validation_user_login_label'), 'required|is_unique['.$tables['users'].'.user_login]');
		$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique['.$tables['users'].'.email]');
		$this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']');
		
		if ($this->form_validation->run() == true)
		{
			$email    = strtolower($this->input->post('email'));
			$password = $this->input->post('password');
			$username = $this->input->post('user_login');
		}
		
		if ($this->form_validation->run() == true && $this->ion_auth->register($username, $password, $email, $additional_data))
		{
			// check to see if we are creating the user
			// redirect them back to the admin page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("user", 'refresh');
		}
		else
		{
			
			// display the create user form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
	
			$this->_render_page('create_user', $this->data);
		}
	}
	
	/**
	 * 
	 * 
	 *
	 * @param int $id
	 * @return void
	 */
	function edit_user($id)
	{
		$user = $this->ion_auth->user($id)->row_array();
		$groups=$this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result_array();
	
		// validate form input
		if (isset($_POST) && !empty($_POST))
		{
			
			// do we have a valid request?
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			{
				show_error($this->lang->line('error_csrf'));
			}
			//转码成gbk 支持access数据库
			$tables = $this->config->item('tables','ion_auth');
			$_POST['user_login'] = auto_charset($this->input->post('user_login'),'utf-8','gbk');
			$this->form_validation->set_rules('user_login', $this->lang->line('create_user_validation_user_login_label'), 'required|is_unique['.$tables['users'].'.user_login]');
			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique['.$tables['users'].'.email]');
			
			// update the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']');
			}
	
			if ($this->form_validation->run() === TRUE)
			{
	
				$data['user_login'] = $this->input->post('user_login');
				$data['email'] = $this->input->post('email');
				// update the password if it was posted
				if ($this->input->post('password'))
				{
					$data['password'] = $this->input->post('password');
				}
	
				
				// Only allow updating groups if user is admin
				if ($this->ion_auth->is_admin())
				{
					//Update the groups user belongs to
					$groupData = $this->input->post('groups');
	
					if (isset($groupData) && !empty($groupData)) {
	
						$this->ion_auth->remove_from_group('', $id);
	
						foreach ($groupData as $grp) {
							$this->ion_auth->add_to_group($grp, $id);
						}
	
					}
				}
				
				// check to see if we are updating the user
				if($this->ion_auth->update( $user['id'], $data))
				{
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', $this->ion_auth->messages() );
					if ($this->ion_auth->is_admin())
					{
						
						redirect($this->data['action_url'].'user', 'refresh');
					}
					else
					{
						redirect('/', 'refresh');
					}
				
				}
				else
				{
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', $this->ion_auth->errors() );
					if ($this->ion_auth->is_admin())
					{
						redirect('user', 'refresh');
					}
					else
					{
						redirect('/', 'refresh');
					}
				
				}
	
			}
		}

	// display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['user'] = $user;
		$this->data['groups'] = $groups;
		$this->data['currentGroups'] = $currentGroups;

		
		$this->data['user_login'] = array(
				'name'  => 'user_login',
				'id'    => 'user_login',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('user_login', auto_charset($user['user_login'])),
		);
		
		$this->data['phone'] = array(
			'name'  => 'phone',
			'id'    => 'phone',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('phone', $user['phone']),
		);
		$this->data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
			'type' => 'password',
			'value' => $this->form_validation->set_value('password'),
		);
		$this->data['email'] = array(
			'name' => 'email',
			'id'   => 'email',
			'type' => 'text',
			'value' => $this->form_validation->set_value('email', $user['email'])
		);

		$this->_render_page('edit_user', $this->data);
	}
	
	function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);
	
		return array($key => $value);
	}
	
	function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
		$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	
	function update(){
		$id = $this->input->post('id');
		
		$user['user_login'] = $this->input->post('user_login');

		if ($this->input->post('user_pass') !=false)  $user['user_pass'] = md5($this->input->post('user_pass') );
		
		$user['user_sex'] = $this->input->post('user_sex') ?$this->input->post('user_sex'):'';
		$user['user_email'] = $this->input->post('user_email') ? $this->input->post('user_email') :'';
		$user['user_mobile'] = $this->input->post('user_mobile') ? $this->input->post('user_mobile'):'';
			
		$user['user_qq'] = $this->input->post('user_qq') ? $this->input->post('user_qq'):'';
		
		$result = $this->db
		->where('id',intval($id))
		->update('users',$user);
		
		redirect('admin/user/index');
	}
	
	function delete($id){
		if ($id == '1') {
			$this->session->set_flashdata('message','管理员不能删除');
			redirect('admin/user/index');
		}
		$result = $this->db
		->where('id',intval($id))
		->update('users',array('status'=>'0'));
		redirect('admin/user/index');
	}
}