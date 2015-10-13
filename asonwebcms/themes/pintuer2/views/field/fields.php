

<div class="admin">
	<form method="post">
		<div class="panel admin-panel">
			<div class="panel-head">
				<strong>字段管理</strong>
			</div>
			<div class="padding border-bottom">
				<input type="button" class="button button-small checkall"
					name="checkall" checkfor="ID" value="全选" />
				<a href="<?php echo site_url('admin/field/add') ?>"
					class="button button-small border-green">添加字段</a>
				<a href="<?php echo site_url('admin/field/delete') ?>"
					class="button button-small border-blue">回收站</a>
			</div>
			<!-- lists row -->
			<table class="table table-hover">
				<tr>
					<th width="45">选择</th>
					<th width="45">字段标识</th>
					<th width="*">名称</th>
					<th width="100">类型</th>
					<th width="100">系统核心默认</th>
					<th width="100">操作</th>
				</tr>
    <?php if ( !empty($lists) && is_array($lists) ) :?>
    <?php foreach ($lists as $list) :?>
    <tr>
					<td>
						<input type="checkbox" name="ID" value="<?php echo $list['id']?>" />
					</td>
<td><?php echo $list['field_slug'] ?></td>
					<td><?php echo $list['field_name']?></td>
					<td><?php echo $field_types[$list['field_type']]?></td>
					<td><span class="icon icon-check"></span></td>
					<td>
						<a class="button border-blue button-little"
							href="<?php echo site_url($url_string.'edit/'.$list['id']) ?>">修改</a>
						<a class="button border-yellow button-little"
							href="<?php echo site_url($url_string.'delete/'.$list['id'] ); ?>"
							onclick="{if(confirm('确认删除?')){return true;}return false;}">删除</a>
					</td>
				</tr>
    <?php endforeach ?>
    <?php else : ?>
    <tr class="red">
					<td colspan="5" class="text-center"><?php echo $this->config->item('empty') ?> <a
							class="button bg-main"
							href="<?php echo site_url('') ?>">添加</a>
					</td>
				</tr>
    <?php endif; ?>
</table>
			<!-- lists row end -->
			<!-- pages -->
			<div class="panel-foot text-center">
    <?php if(!empty($pages)) echo $pages; ?>
</div>
			<!-- pages end -->
		</div>
	</form>
	<br />
</div>