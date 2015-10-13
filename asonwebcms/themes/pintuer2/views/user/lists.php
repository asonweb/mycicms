
<div class="admin">
	<form method="post">
		<?php if ( $this->session->flashdata('message')!=null ){
			echo ('<div class="alert alert-red">'.$this->session->flashdata('message').'</div>');
		}
		?>
		<div class="panel admin-panel">
			<div class="panel-head">
				<strong>会员管理</strong>
			</div>
			<div class="padding border-bottom">
				<input type="button" class="button button-small checkall"
					name="checkall" checkfor="id" value="全选" />
			</div>

			<table class="table table-hover">
				<tr>
					<th width="45">选择</th>
					<th width="45">id</th>
					<th width="*">名称</th>
					<th width="*">性别</th>
					<th>手机号码</th>
					<th width="45">QQ</th>
					<th width="100">时间</th>
					<th width="160">操作</th>
				</tr>
    <?php if ( !empty($lists) && is_array($lists) ) :?>
    <?php foreach ($lists as $list) :?>
    <tr>
					<td>
						<input type="checkbox" name="id" value="<?php echo $list['id']?>" />
					</td>
					<td><?php echo $list['id'] ?></td>
					
					<td><?php echo $list['user_login']?></td>
					<td><?php echo ( $list['user_sex'] !== null ? ($list['user_sex'] =='1'? '男' : '女') : ''); ?></td>
					<td><?php echo $list['user_mobile']?></td>
					<td><?php echo $list['user_qq']?></td>
					<td><?php echo $list['createtime']?></td>
					<td>
						<a class="button border-blue button-little"
							href="<?php echo site_url('admin/user/edit/'.$list['id']) ?>">修改</a>
						<a class="button border-yellow button-little"
							href="<?php echo site_url('admin/user/delete/'.$list['id'] ); ?>"
							onclick="{if(confirm('确认删除?')){return true;}return false;}">删除</a>
					</td>
				</tr>
    <?php endforeach ?>
    <?php else : ?>
    <tr class="red">
					<td colspan="5" class="text-center"><?php echo $this->config->item('empty') ?> <a
							class="button bg-main"
							href="<?php echo site_url('admin/user/add/') ?>">添加</a>
					</td>
				</tr>
    <?php endif; ?>
</table>

			<div class="panel-foot text-center">
    <?php if(!empty($pages)) echo $pages; ?>
</div>
		</div>
	</form>
	<br />
</div>