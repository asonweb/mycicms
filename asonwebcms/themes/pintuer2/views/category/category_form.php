<div class="admin">
<!-- form -->

<?php if($action !== 'parent'):?>
<?php echo form_open_multipart('admin/category/form/'.$name['slugname'].'/'.$id,array('class'=>'form-x')); ?>
<?php else:?>
<?php echo form_open_multipart('admin/category/parent/'.$name['slugname'].'/'.$pid,array('class'=>'form-x')); ?>
<?php endif;?>
<?php echo form_hidden('typeid',$name['id']); ?>
<div class="tab">
		<div class="tab-head">
			<strong>分类表单</strong>
			<ul class="tab-nav">
				<li class="active">
					<a href="#description_tab">分类描述</a>
				</li>
				<li>
					<a href="#attributes_tab">分类属性</a>
				</li>
				<li>
					<a href="#seo_tab">SEO设置</a>
				</li>
			</ul>
		</div>


		<div class="tab-body">
			<div class="tab-panel active" id="description_tab">

			<div class="bg-red-light text-dot">
				<?php echo validation_errors(); ?></div>
		
				<div class="form-group">
					<div class="label">
						<label for="pid">上级栏目</label>
					</div>
					<div class="field">
					<select name="pid">
					<option class="0">作为一级分类</option>
				<?php echo $categories;?>
				</select>
				</div>
				</div>

				<div class="form-group">
					<div class="label">
						<label for="name">名称</label>
					</div>
					<div class="field">
				<?php
				
				$data = array (
						'name' => 'name',
						'value' => set_value ( 'name', $catname ),
						'class' => 'input' 
				);
				echo form_input ( $data );
				?>
				</div>
				</div>
				<div class="form-group">
					<div class="label">
						<label for="content">详细介绍</label>
					</div>
					<div class="field">
				<?php
				$data = array (
						'name' => 'content',
						'id' => 'content',
						'class' => 'redactor',
						'value' => set_value ( 'description', $content ) 
				);
				echo form_textarea ( $data );
				?>
				</div>
				</div>
				<div class="form-group">
					<div class="label">
						<label for="status">启用</label>
					</div>
					<div class="field"><?php echo form_dropdown('status', array('0' => '禁用', '1' => '启用'), set_value('status',$status)); ?></div>
				</div>
				<div class="form-group">
					<div class="label">
						<label for="thumb">分类图</label>
					</div>
					<div class="field">
						<input type="hidden" name="thumb" id="thumb" value="">
						<img src="" id="thumb_preview" width="135" height="113" style="cursor:hand">
						<script id="thumb_editor"></script>
                        <input type="button" id='image' value='上传图片'/>
					<?php echo form_hidden('thumb',set_value ( 'name', $thumb ));?>
					<span class="add-on">文件最大<?php echo  $this->config->item('size_limit')/1024; ?>kb</span>
					</div>
				</div>

				<div class="form-button">
					<button class="button bg-main" type="submit">提交</button>
				</div>

			</div>

			<div class="tab-panel" id="attributes_tab">未开发</div>
			<div class="tab-panel" id="seo_tab">未开发</div>
		</div>

	</div>


	</form>
	<!--  -->
</div>
<script type="text/javascript"
	src="<?php echo base_url('statics/ueditor/ueditor.config.js')?>"></script>
<script type="text/javascript"
	src="<?php echo base_url('statics/ueditor/ueditor.all.js')?>"></script>
<script type="text/javascript">
$(function(){
	var ue = UE.getEditor('content');
	var _editor = UE.getEditor('thumb_editor');
	_editor.ready(function () {
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
})

$('form').submit(function() {
	$('.btn').attr('disabled', true).addClass('disabled');
});
</script>