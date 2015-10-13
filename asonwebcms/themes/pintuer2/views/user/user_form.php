<div class="admin">
    
     <?php echo form_open('admin/user/update'); ?>
<input type="hidden" name="id" value="<?php echo $user['id'] ?>" />

<div class="clear clearfix"></div>
<div class="panel thumb-panel">
	<table class="table">
		<tbody>
			<tr>
				<td>
					<b>用户信息</b>
				</td>
			</tr>

			<tr>
				<td>
					<b>发布时间</b>
				</td>
			</tr>
			<tr>
				<td>
					<input type="text" name="createtime" id="updatetime"
						value="<?php echo date('Y-m-d G:i:s',$user['createtime'])?>" size="21"
						class="input ui_date">
				</td>
			</tr>
			<tr>
				<td>
					<b>状态</b>
				</td>
			</tr>
			<tr>
				<td>
					<span class="switch_list cc">
						<label>
							<input type="radio" name="status" value="1" checked="">
							<span>审核通过</span>
						</label>
						<label>
							<input type="radio" name="status" value="0">
							<span>待审核</span>
						</label>
					</span>
				</td>
			</tr>
			
		</tbody>
	</table>
</div>
<div class="panel admin-panel add-panel">
	<div class="panel-head">
		<strong>
			用户详细
		</strong>
	</div>
	<table class="table tabel-hover">

	<tr>
	<td>会员账号</td>
	<td><input name="user_login" value="<?php echo $user['user_login']?>"></td></tr>
	<tr>
	<td>会员密码</td>
	<td><input name="user_pass" value="" />不输入密码不变，输入可以修改密码</td></tr>
	<tr>
	<td>邮箱</td>
	<td><input name="user_email" value="<?php echo $user['user_email']?>" /></td></tr>
	<tr>
	<td>手机号码</td>
	<td><input name="user_mobile" value="<?php echo $user['user_mobile']?>" /></td></tr>
	<tr>
	<td>qq</td>
	<td><input name="user_qq" value="<?php echo $user['user_qq']?>" /></td></tr>
	<tr>
	<td>性别</td>
	<td><select name="user_sex" id="user_sex">
                <option value="" <?php echo $user['user_sex']==null ? 'selected' : '' ?>>请选择</option>
                <option value="1" <?php echo $user['user_sex']=='1' ? 'selected' : '' ?>>男</option>
                <option value="0" <?php echo $user['user_sex']=='0' ? 'selected' : '' ?>>女</option>
              </select></td></tr>
	<tr>
			<td></td>
			<td>
				<div class="fixed" data-style="fixed-bottom" data-offset-fixed="10"><input class="button bg-main" type="submit" value="提交" />
			</div>
			</td>
		</tr>
	</table>
	
</div>

<br />
</form>

<script type="text/javascript"
	src="<?php echo base_url('statics/ueditor/ueditor.config.js')?>"></script>
<script type="text/javascript"
	src="<?php echo base_url('statics/ueditor/ueditor.all.js')?>"></script>
<script type="text/javascript">
    (function($) {
    	$(".ui_date").datepicker(); 
    	var ue = UE.getEditor('container');
    	
    	var _editor = UE.getEditor('thumb_editor');
	      _editor.ready(function () {
	         // _editor.setDisabled();
	          _editor.hide();
	         _editor.addListener('beforeInsertImage', function (t, arg) {
	             $("#thumb").val(arg[0].src);
	             $("#thumb_preview").attr("src", arg[0].src);
	         })
	     });
	     function upImage() {
	         var myImage = _editor.getDialog("insertimage");
	         myImage.open();
	     }
	     $('#image').click(function(){
	    	 upImage();
	     });
    })(jQuery);
</script>


     
    
</div>