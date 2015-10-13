<div class="admin">
	<div class="panel admin-panel">
	<div class="panel-head">
			<strong>编辑用户</strong>
		</div>
<h1><?php echo lang('edit_user_heading');?></h1>
<p><?php echo lang('edit_user_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open(uri_string(),'class="form-x form-normal"');?>

      <div class="form-group">
      	<div class="label">用户名</div>
      	<div class="field"> <?php echo form_input($user_login);?></div> 
      </div>
      
      <div class="form-group">
      	<div class="label">密码</div>
      	<div class="field"> <?php echo form_input($password);?></div> 
      </div>
      
      <div class="form-group">
      	<div class="label">邮箱</div>
      	<div class="field"> <?php echo form_input($email);?></div> 
      </div>
      
      <div class="form-group">
      	<div class="label">角色</div>
      	<div class="field">
      	<?php if ($this->ion_auth->is_admin()): ?>

          <h3><?php echo lang('edit_user_groups_heading');?></h3>
          <?php foreach ($groups as $group):?>
              <label class="checkbox">
              <?php
                  $gID=$group['id'];
                  $checked = null;
                  $item = null;
                  foreach($currentGroups as $grp) {
                      if ($gID == $grp['id']) {
                          $checked= ' checked="checked"';
                      break;
                      }
                  }
              ?>
              <input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
              <?php echo htmlspecialchars($group['role_description'],ENT_QUOTES,'UTF-8');?>
              </label>
          <?php endforeach?>

      <?php endif ?>
      	</div> 
      </div>

      

      <?php echo form_hidden('id', $user['id']);?>
      <?php echo form_hidden($csrf); ?>

      <div class="form-group">
                    <div class="label"></div>
                    <div class="field">
                    	<?php echo form_submit('submit', '编辑用户','class="button bg-main"');?>
             		</div>
         </div>

<?php echo form_close();?>
	</div>
</div>