<form method="post" class="form-x" action="<?php echo site_url('admin/system/setting') ?>">
        	<input type="hidden" name="ID" value="2" />
        	<div class="form-group">
	        	<div class="label"><label for="desc">开启邮箱激活</label></div>
	            <div class="field"><label><input type="radio" name="emailstate"> 开启</label>
	                   <label><input type="radio" name="emailstate"> 关闭</label></div> 
            </div>
            <div class="form-group">
	        	<div class="label"><label for="desc">邮件标题</label></div>
	            <div class="field">
	            <input type="text" class="input" id="emailtitle" name="emailtitle" size="50" placeholder="邮件激活通知" value="" />
	            </div> 
            </div>
            <div class="form-group">
	        	<div class="label"><label for="desc">邮件标题</label></div>
	            <div class="field">
	            <input type="text" class="input" id="emailtitle" name="emailtitle" size="50" placeholder="邮件激活通知" value="" />
	            </div> 
            </div>
            <div class="form-group">
	        	<div class="label"><label for="desc">邮件模板</label></div>
	            <div class="field">
	            <textarea class="input" name="emailtemp" rows="5" cols="50" ></textarea>
	            </div> 
            </div>
            <div class="form-button"><button class="button bg-main" type="submit">提交</button></div>
        	</form>