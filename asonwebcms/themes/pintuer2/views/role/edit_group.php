<div class="admin">
	<div class="panel admin-panel">
	<div class="panel-head">
			<strong>编辑角色</strong>
		</div>
<h1><?php echo lang('edit_user_heading');?></h1>
<p><?php echo lang('edit_user_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open(current_url(),'class="form-x"');?>

	<div class="form-group">
      	<div class="label">用户名</div>
      	<div class="field"> <?php echo form_input($role_name);?></div> 
      </div>
      <p>
            <?php echo lang('edit_group_name_label', 'group_name');?> <br />
            <?php echo form_input($group_name);?>
      </p>

      <p>
            <?php echo lang('edit_group_desc_label', 'description');?> <br />
            <?php echo form_input($group_description);?>
      </p>

      <p><?php echo form_submit('submit', lang('edit_group_submit_btn'));?></p>

<?php echo form_close();?>
	</div>
</div>
