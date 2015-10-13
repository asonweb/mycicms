
<form method="post" class="form-x" action="<?php echo site_url('admin/system/setting') ?>">
<input type="hidden" name="ID" value="3" />
<div class="form-group">
<div class="label"><label for="maxsize">总最大上传文件大小</label></div>
<div class="field">
<input type="text" class="" id="maxsize" name="maxsize" size="10" placeholder="" value="" /> MB
</div>
</div>
<div class="form-group">
<div class="label"><label for="maxsize">产品上传文件大小</label></div>
<div class="field">
<input type="text" class="" id="maxsize" name="maxsizepro" size="10" placeholder="" value="" /> KB
</div>
</div>
<div class="form-group">
<div class="label"><label for="water">开启图片水印</label></div>
<div class="field">
<div class="button-group button-group-small radio">
<label class="button"><input name="water" value="yes"  type="radio"><span class="icon icon-check"></span> 开启</label>
<label class="button active"><input name="water" value="no" type="radio" checked="checked"><span class="icon icon-times"></span> 关闭</label>
</div>
</div>
</div>
<div class="form-button"><button class="button bg-main" type="submit">提交</button></div>
</form>