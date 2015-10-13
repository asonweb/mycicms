

<div style="text-align:right">
	<a class="btn" href="<?php echo site_url('admin/category/form'); ?>"><i class="icon-plus-sign"></i> </a>
</div>

<table class="table table-hover">
    <thead>
		<tr>
			<th>id</th>
			<th>名称</th>
			<th>排序</th>
			<th>状态</th>
			<th><div class="text-right" style="padding-right:30px;">操作</div></th>
		</tr>
	</thead>
	<tbody>
		<?php if(!empty($list_tables))echo $list_tables?>
	</tbody>
	
</table>
<div class="panel-foot text-center clearfix">
	<div class="float-left padding-top">
	
    <button class="button button-small border-blue" onclick="myform.action='<?php echo site_url('admin/category/sort')?>';$('#myform').submit();">排序</button>
 
	</div>
	
</div>