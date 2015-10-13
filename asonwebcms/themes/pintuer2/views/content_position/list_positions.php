

<div class="admin">
	<div class="panel admin-panel">
		<div class="panel-head">推荐位管理</div>
		<form method="post" class="form-x form-auto" action='<?php echo current_url()?>'>
			<table class="table table-hover">
	<tr>
		<th width="45">选择</th>
		<th width="45">id</th>
		<th width="120">名称</th>

		<th width="100">操作</th>
	</tr>
	<?php if ( !empty($lists) && is_array($lists) ) :?>
	<?php foreach ($lists as $id => $name) :?>
	<tr>
		<td>
			<input type="checkbox" name="id" value="<?php echo $id?>" />
		</td>
		<td>
			<?php echo $id ?>
		</td>
		<td>
			<?php echo $name?>
		</td>
		<td>
			<a class="button border-blue button-little"
				href="<?php echo site_url('admin/position/edit_position/'.$id) ?>">修改</a>
			<a class="button border-yellow button-little"
				href="<?php echo site_url('admin/position/delete_position/'.$id ); ?>"
				onclick="{if(confirm('确认删除?')){return true;}return false;}">删除</a>
		</td>
	</tr>
	<?php endforeach ?>
	<?php else : ?>
	<tr class="red">
		<td colspan="5" class="text-center">
			<?php no_result('没有内容') ?>
			<a class="button bg-main"
				href="<?php echo site_url('admin/content/add/'.$name['slugname']) ?>">添加</a>
		</td>
	</tr>
	<?php endif; ?>
</table>
			
		</form>
	</div>
	
</div>
