

<div class="admin">
	<?php if( isset($msg)  and $msg['type'] == 0 )  : ?>
			<div class="alert alert-red"><?php echo $msg['msg']?></div>
			<?php endif;?>
	<div class="panel admin-panel">
		<div class="panel-head">编辑推荐位</div>
		<form method="post" class="form-x form-auto" action='<?php echo site_url('admin/position/update_position/'.$id)?>'>
			<input type="hidden" name="id" value="<?php echo $id;?>" />
			
			<div class="form-group">
				<div class="label">推荐位名称</div>
				<div class="field">
				<input type="text" name="name" value="<?php echo $name?>" class="input input-auto" />
				<div class="input-note"></div>
				</div>
			</div>
			<div class="form-group">
				<div class="label"></div>
				<div class="field"><input type="submit" name="add_position" class="button bg-main" value="编辑推荐位" /></div>
			</div>
		</form>
	</div>
	
</div>
