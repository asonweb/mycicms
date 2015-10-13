<?php echo form_open('admin/content/insert/'.$name['slugname']); ?>
<input type="hidden" name="typeid" value="<?php echo $name['id'] ?>" />
<input type="hidden" name="forward" value="<?php echo $forward ?>" />
<div class="panel thumb-panel padding">
	<table>
		<tbody>
			<tr>
				<td>
					<b>缩略图</b>
				</td>
			</tr>
			<tr>
				<td>
					<div style="text-align: center;">
						<input type="hidden" name="thumb" id="thumb" value="">
						<img src="" id="thumb_preview" width="135" height="113" style="cursor:hand">
						<script id="thumb_editor"></script>
                        <input type="button" id='image' value='上传图片'/>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<b>发布时间</b>
				</td>
			</tr>
			<tr>
				<td>
					<input type="text" name="createtime"
						value="" size="21"
						class="input ui_date" id="date">
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
			添加
			<?php echo $name['name'] ?>
		</strong>
	</div>
	<table class="table table-hover">
		<tr>
			<td></td>
			<td class="text-dot">
				<?php echo validation_errors(); ?>
			</td>
		</tr>
		<tr>
			<td>所属分类</td>
			<td><select name="catid" class="input input-auto"><option value="">选择分类</option><?php echo $categories;?></<select></td>
		</tr>
		<tr>
			<td>标题</td>
			<td>
				<input type="text" class="input input-auto" id="title" name="title" size="50"
					placeholder="请输入标题" data-validate="required:请填写标题，建议在100字以内。"
					value="<?php echo set_value('title'); ?>" />
			</td>
		</tr>
<tr>
			<td>推荐位</td>
			<td>
				<?php  foreach ( $this->model->position as $id => $pos ) : ?>
				<input type="checkbox" name="pos[]" value="<?php echo $id; ?>" /><?php echo $pos; ?>
				<?php endforeach;?>
			</td>
		</tr>
		<tr>
			<td>概要</td>
			<td>
				<input type="text" class="input input-auto" id="expcert" name="expcert"
					size="50" data-validate="required:请填写标题，建议在100字以内。" value="<?php echo set_value('expcert'); ?>" />
			</td>
		</tr>

		<tr>
			<td>内容</td>
			<td>
				<div style="max-width: 920px;">
					<script type="text/plain" id="content" name="content"><?php echo set_value('content'); ?></script>
				</div>
			</td>
		</tr>

		<tr>
			<td></td>
			<td>
				<input class="button bg-main" type="submit" value="提交" />
			</td>
		</tr>

	</table>
</div>
<br />
</form>

<script type="text/javascript"
	src="<?php echo base_url('statics/ueditor/ueditor.config.js')?>"></script>
<script type="text/javascript"
	src="<?php echo base_url('statics/ueditor/ueditor.all.min.js')?>"></script>
<script type="text/javascript">
    (function($) {
    	// 日期时间控件
        $('#date').datetimepicker({
            currentText     :   '现在',
            prevText        :   '上一月',
            nextText        :   '下一月',
            monthNames      :   ['一月', '二月', '三月', '四月',
                '五月', '六月', '七月', '八月',
                '九月', '十月', '十一月', '十二月'],
            dayNames        :   ['星期日', '星期一', '星期二',
                '星期三', '星期四', '星期五', '星期六'],
            dayNamesShort   :   ['周日', '周一', '周二', '周三',
                '周四', '周五', '周六'],
            dayNamesMin     :   ['日', '一', '二', '三',
                '四', '五', '六'],
            closeText       :   '完成',
            timeOnlyTitle   :   '选择时间',
            timeText        :   '时间',
            hourText        :   '时',
            amNames         :   ['上午', 'A'],
            pmNames         :   ['下午', 'P'],
            minuteText      :   '分',
            secondText      :   '秒',
            dateFormat      :   'yy-mm-dd',
            hour            :   (new Date()).getHours(),
            minute          :   (new Date()).getMinutes()
        }); 
        
    	var ue = UE.getEditor('content');
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


