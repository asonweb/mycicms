<div class="admin">
		<div class="panel admin-panel">
			<div class="panel-head">
				<strong><?php echo $name['name'] ?>内容</strong>
			</div>
			<div class="padding border-bottom clearfix">
				<div class="float-left">
				<a
					href="<?php echo site_url('admin/content/add/'.$name['slugname']) ?>"
					class="button button-small border-green">添加文章</a>
				</div>
				<!-- search -->
				<form class="form-x float-left margin-left" action="<?php echo current_url(); ?>">
				<?php echo $positions; ?>
				<select class="input input-auto" name="catid">
					<option value="">选择分类</option>
					<?php echo $categories; ?>
				</select>
				名称<input type="text" name="keywords" value="" class="input input-auto" />
				每页显示数量
				<input type="text" name="pagesize" value="" class="input input-auto" size="5" />
				<input class="button bg-main" type="submit" value="搜索" />
				</form>
				<!-- search -->
			</div>
			<?php echo $body; ?>
		</div>
	
</div>

<script>
$(function(){
	$('#cat').change(function(){
		$('form').attr('action',"<?php echo site_url('admin/content/update_cat/'.$name['slugname']) ?>");
		$('form').submit();
	})
})
</script>