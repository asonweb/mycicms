<div class="admin">
 	<div class="panel admin-panel">
 	<div class="panel-head">
			<strong>创建用户</strong>
		</div>

	<div id="alert"><?php echo $message;?></div>
	
	<?php echo form_open($action_url."create_user",'class="form-x form-normal"');?>
	
		<div class="form-group">
                    <div class="label"><label for="sitename">用户名</label></div>
                    <div class="field">
                    	<?php echo form_input('user_login',set_value('user_login'));?>
             </div>
         </div>
         <div class="form-group">
                    <div class="label"><label for="sitename">密码</label></div>
                    <div class="field">
                    	<?php echo form_input('password', set_value('password'));?>
             </div>
         </div>
		<div class="form-group">
                    <div class="label"><label for="sitename">邮箱</label></div>
                    <div class="field">
                    	<?php echo form_input('email',set_value('email'));?>
             		</div>
         </div>
         <div class="form-group">
                    <div class="label"></div>
                    <div class="field">
                    	 <?php echo form_submit('submit', '创建用户','class="button bg-main"');?>
             		</div>
         </div>
	     
	
	<?php echo form_close();?>
	</div>
</div>