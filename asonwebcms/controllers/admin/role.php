<?php

class Role extends AdminController{
	
	function __construct(){
		parent::__construct();
		$this->load->model('users_model');
	}
	
	function lists(){
		
	}
	
	function edit_group($id)
	{
		// bail if no group id given
		if(!$id || empty($id))
		{
			redirect('auth', 'refresh');
		}

		$group = $this->ion_auth->group((int)$id)->row_array();
	
		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');
	
		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() === TRUE)
			{
				$group_update = $this->ion_auth->update_group($id, $_POST['role_code'], array($_POST['role_name'],$_POST['role_description']));
	
				if($group_update)
				{
					$this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
				redirect("auth", 'refresh');
			}
		}
	
		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
	
		// pass the user to the view
		$this->data['group'] = $group;
	
		$readonly = $this->config->item('admin_group', 'ion_auth') === $group['role_name'] ? 'readonly' : '';
	
		$this->data['role_code'] = array(
				'name'  => 'role_code',
				'id'    => 'role_code',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('role_code', $group['role_code']),
				$readonly => $readonly,
		);
		
		$this->data['role_name'] = array(
				'name'  => 'role_name',
				'id'    => 'role_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('role_name', $group['role_name']),
				$readonly => $readonly,
		);
		
		$this->data['role_description'] = array(
				'name'  => 'role_description',
				'id'    => 'role_description',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('role_description', $group['role_description']),
		);
	
		$this->_render_page('edit_group', $this->data);
	}
}