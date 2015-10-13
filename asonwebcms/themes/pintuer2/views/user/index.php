
<div class="admin">
	<div class="panel admin-panel margin-bottom">
	<div class="form-bloc padding bg-back">
			<form name="userFilter" id="userFilter" method="post" action="<?php echo site_url($action_url.'lists')?>">
				<?php echo form_dropdown('role_id', $groups_options, $this->input->post('role_id') ); ?>
				<label class="over">
					邮箱
					<input alt="Email" type="text" class=""
						id="filter_email" name="email" value="<?php echo $this->input->post('email')?>">
				</label>
<label class="over">
					用户名
					<input type="text" class="" id="filter_screenname"
						name="user_login" value="<?php echo $this->input->post('user_login')?>">
				</label>
				<label class="over">
					姓名
					<input type="text" class="inputtext w140" id="filter_screenname"
						name="user_nicename" value="<?php echo $this->input->post('user_nicename')?>">
				</label>

				<label class="over">
					用户/页
					<input type="text" class="inputtext w40" id="filter_nb" name="pagesize"
						value="<?php echo $this->input->post('pagesize')?>">
				</label>

				<button class="button bg-main" type="submit">筛选</button>
			</form>
		</div>
	</div>
	
	<div class="panel admin-panel">
		<div id="infoMessage"><?php echo $message;?></div>
		<div class="panel-head">
			<strong>用户</strong>
		</div>
		<div class="padding border-bottom">
			<input type="button" class="button button-small checkall"
				name="checkall" checkfor="id" value="全选">
			<?php echo anchor($action_url.'create_user', '创建用户', 'class="button button-small border-green"')?>
			<?php echo anchor($action_url.'create_group', '创建用户组', 'class="button button-small border-yellow"')?>
		</div>
		<table cellpadding=0 cellspacing=10 class="table table-hover">
			<tr>
				<th>账号</th>
				<th>姓名</th>
				<th><?php echo lang('index_email_th');?></th>
				<th>角色名</th>
				<th><?php echo lang('index_status_th');?></th>
				<th><?php echo lang('index_action_th');?></th>
			</tr>
	<?php foreach ($users as $user):?>
		<tr>
				<td><?php echo htmlspecialchars($user['user_login'],ENT_QUOTES,'UTF-8');?></td>
				<td><?php echo htmlspecialchars($user['user_nicename'],ENT_QUOTES,'UTF-8');?></td>
				<td><?php echo htmlspecialchars($user['email'],ENT_QUOTES,'UTF-8');?></td>
				<td>
				
				<?php foreach ($user['groups'] as $group):?>
					<?php echo anchor( $action_group."role/edit_group/".$group['id'], htmlspecialchars(auto_charset($group['role_description']),ENT_QUOTES,'UTF-8')) ;?><br />
                <?php endforeach?>
			</td>
				<td><?php echo ($user['active']) ? anchor("auth/deactivate/".$user['id'], '激活') : anchor("auth/activate/". $user['id'], '未激活');?></td>
				<td><?php echo anchor( $action_url."edit_user/".$user['id'], '编辑') ;?></td>
			</tr>
	<?php endforeach;?>
</table>


	</div>
	
</div>
