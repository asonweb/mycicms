<?php if ( $action == 'add' ) : ?>
<div class="admin">
<!-- field form -->
	<?php echo form_open( $url_string.'insert', 'class="form-horizontal"'); ?>
	<?php echo form_hidden('id', isset($id)? $id : '');?>
    <div class="tab">
		<div class="tab-head">
			<strong>字段表单</strong>
			<ul class="tab-nav">
				<li class="active">
					<a href="#description_tab">字段描述</a>
				</li>
				
			</ul>
		</div>

		<div class="tab-body">
			<div class="tab-panel active" id="description_tab">

			<?php if ( validation_errors() ) :?>
			<div class="alert bg-red-light text-dot"><?php echo validation_errors();?></div>
			<?php endif;?>
		
				<div class="form-group">
					<div class="label">
						<label for="field_name">名称</label>
					</div>
					<div class="field">
				<?php
				$data = array (
						'name' => 'field_name',
						'value' => set_value ( 'field_name' ),
						'class' => 'input' 
				);
				echo form_input ( $data );
				?>
				</div>
				</div>
				<div class="form-group">
					<div class="label">
						<label for="slug">标识</label>
					</div>
					<div class="field">
					<?php
				$data = array (
						'name' => 'field_slug',
						'value' => set_value ( 'field_slug' ),
						'class' => 'input' 
				);
				echo form_input ( $data );
				?>
				</div>
				</div>
				<div class="form-group">
					<div class="label">
						<label for="content">字段类型</label>
					</div>
					<div class="field">
				<?php $field_types['0']='请选择字段'; echo form_dropdown('field_type', $field_types, '0','class="input" id="field_type"');?>
				</div>
				<div id="option_field"></div>
				</div>
				<div class="form-group">
					<div class="label">
						<label for="status">启用</label>
					</div>
					<div class="field">
					<?php echo form_dropdown('status', array('0' => '禁用', '1' => '启用'), '1'); ?></div>
				</div>
				<div class="form-button">
					<button class="button bg-main" type="submit">提交</button>
				</div>
			</div>

			
		</div>

	</div>
    </form>
<!-- field form end -->
    <br />
</div>
<?php endif;?>
<?php if ( $action == 'edit' or $action=='update' ) : ?>
<div class="admin">
<!-- field form -->
	<?php echo form_open( $url_string.'update', 'class="form-horizontal"'); ?>
	<?php echo form_hidden('id', isset($id)? $id : '');?>
    <div class="tab">
		<div class="tab-head">
			<strong>字段表单</strong>
			<ul class="tab-nav">
				<li class="active">
					<a href="#description_tab">字段描述</a>
				</li>
				
			</ul>
		</div>

		<div class="tab-body">
			<div class="tab-panel active" id="description_tab">

			<?php if ( validation_errors() ) :?>
			<div class="alert bg-red-light text-dot"><?php echo validation_errors();?></div>
			<?php endif;?>
		
				<div class="form-group">
					<div class="label">
						<label for="field_name">名称</label>
					</div>
					<div class="field">
				<?php
				$data = array (
						'name' => 'field_name',
						'value' => set_value ( 'field_name', $field['field_name'] ),
						'class' => 'input' 
				);
				echo form_input ( $data );
				?>
				</div>
				</div>
				<div class="form-group">
					<div class="label">
						<label for="slug">标识</label>
					</div>
					<div class="field">
					<?php
				$data = array (
						'name' => 'field_slug',
						'value' => set_value ( 'field_slug', $field['field_slug'] ),
						'class' => 'input' 
				);
				echo form_input ( $data );
				?>
				</div>
				</div>
				<div class="form-group">
					<div class="label">
						<label for="content">字段类型</label>
					</div>
					<div class="field">
				<?php $field_types['0']='请选择字段'; echo form_dropdown('field_type', $field_types, $field['field_type'],'class="input" id="field_type"');?>
				</div>
				<div id="option_field"></div>
				</div>
				<div class="form-group">
					<div class="label">
						<label for="status">启用</label>
					</div>
					<div class="field">
					<?php echo form_dropdown('status', array('1' => '启用', '0' => '禁用'), $field['status']); ?></div>
				</div>
				<div class="form-button">
					<button class="button bg-main" type="submit">提交</button>
				</div>
			</div>

			
		</div>

	</div>
    </form>
<!-- field form end -->
    <br />
</div>
<?php endif;?>
<script>
$(function(){
	//field_type select change 回调函数
	$('#field_type').change(function(){
		$type = $(this).children(':selected').attr('value');
		$.ajax({
			type : 'post',
			url : "<?php echo site_url('admin/field/xhr_build_params')?>",
			data : {type:$type},
			success : function(data){
				$('#option_field').html(data);
			},
		})
	})
})
</script>
