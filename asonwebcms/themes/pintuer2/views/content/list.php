
<form action="" method="post" name="myform" id="myform">
<table class="table table-hover">
	<tr>
		<th width="45">
		<input type="button" class="button button-small checkall"
					name="checkall" checkfor="id[]" value="全选" /></th>
		<th width="45">id</th>
		<th width="*">名称</th>
		<th width="100">排序数字</th>
		<th width="120">分类</th>
		<th width="100">时间</th>
		<th width="250">操作</th>
	</tr>
	<?php if ( !empty($lists) ) :?>
	<?php foreach ( $lists as $list ) :?>
	<tr>
		<td>
			<input type="checkbox" name="id[]" value="<?php echo $list['id']?>" />
		</td>
		<td>
			<?php echo $list['id'] ?>
		</td>
		<td>
			<a class="name" href="<?php echo site_url('admin/content/edit/'.$name['slugname'].'/'.$list['id']) ?>"><?php echo $list['title']?></a>
		</td>
		<td>
    	<div style="width: 50px;"><input type="text" name="sort[<?php echo $list['id'] ?>]" value="<?php if(!empty($list['sort'])) echo $list['sort'] ?>" class="input" /></div>
    	</td>
		<td>
			<?php if($list['catid']) echo $categories_lists[$list['catid']]['name']?>
		</td>
		
		<td><?php echo date('Y-m-d',$list['createtime']) ?></td>
		<td>
			<a class="button border-blue button-little"
				href="<?php echo site_url('admin/content/edit/'.$name['slugname'].'/'.$list['id']) ?>">修改</a>
			<?php if( $this->input->get('status')!=='trash'):?>
			<a class="button border-yellow button-little"
				href="<?php echo site_url('admin/content/delete/'.$list['id'].'?trash=trash' ); ?>"
				onclick="{if(confirm('确认删除?')){return true;}return false;}">删除</a>
			<?php else:?>
			<a class="button border-yellow button-little"
				href="<?php echo site_url('admin/content/delete/'.$list['id'].'?restore=restore' ); ?>"
				onclick="{if(confirm('确认恢复?')){return true;}return false;}">恢复</a>
			<a class="button border-yellow button-little"
				href="<?php echo site_url('admin/content/delete/'.$list['id'].'?trash=delete' ); ?>"
				onclick="{if(confirm('确认要将选择的永久删除?回收站中删除将无法找回')){return true;}return false;}">删除</a>
			<?php endif;?>
				<a class="button win-forward" href="<?php echo site_url('index/view/'.$name['slugname'].'/'.$list['id']); ?>">浏览 <span class="icon-arrow-right"></span></a>
		</td>
	</tr>
	<?php endforeach ?>
	<?php else : ?>
	<tr class="red">
		<td colspan="7" class="text-center">
			<?php no_result('没有内容') ?>
			<a class="button bg-main"
				href="<?php echo site_url('admin/content/add/'.$name['slugname']) ?>">添加</a>
		</td>
	</tr>
	<?php endif; ?>
</table>

<div class="panel-foot text-center clearfix">
	<div class="float-left padding-top">
	<a href="<?php echo site_url('admin/position/add_position') ?>"
						class="button button-small border-blu">添加推荐位</a>
					<a href="<?php echo site_url('admin/position/list_positions') ?>"
						class="button button-small border-blu">推荐位管理</a>
	<select id="cat" class="input input-auto" name="cat">
    	<option value="">转移分类</option>
    	<?php echo $categories; ?>
    </select>
    <button class="button button-small border-blue" onclick="myform.action='<?php echo site_url('admin/content/update_sort')?>';$('#myform').submit();">排序</button>
    <?php if( $this->input->get('status') !=='trash' ) :?>
    <button class="button button-small border-blue" onclick="myform.action='<?php echo site_url('admin/content/delete?trash=trashin')?>';$('#myform').submit();">回收站</button>
    <?php else:?>
     <button class="button button-small border-blue" onclick="myform.action='<?php echo site_url('admin/content/delete?trash=deleteain')?>';$('#myform').submit();">清空回收站</button>
     <button class="button button-small border-blue" onclick="myform.action='<?php echo site_url('admin/content/delete?restore=restorein')?>';$('#myform').submit();">批量恢复</button>
    <?php endif;?>
	</div>
	<div class="float-right">
	<?php if(!empty($pages)) echo $pages; ?>
	</div>
</div>
</form>
<script>
$(function(){
	$('#cat').change(function(){
		$('#myform').attr('action',"<?php echo site_url('admin/content/update_cat/'.$name['slugname']) ?>");
		$('#myform').submit();
	})
})
</script>