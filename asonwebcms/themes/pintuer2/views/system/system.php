
<div class="admin">
	<div class="alert alert-yellow">
		<p class="icon-smile-o text-big">操作提示</p>
		网站全局基本设置，其他内容在其他模块操作。
	</div>
	<div class="tab">
		<div class="tab-head">
			<strong>系统设置</strong>
			<ul class="tab-nav">
				<li class="active">
					<a href="#tab-set">系统设置</a>
				</li>
				<li>
					<a href="#tab-email">联系方式</a>
				</li>
				<li>
					<a href="#tab-upload">SEO设置</a>
				</li>
			</ul>
		</div>
		<div class="tab-body">
			<br />
			<div class="tab-panel active" id="tab-set">
				<form method="post" class="form-x"
					action="<?php echo site_url('admin/setting/save') ?>">
					<input type="hidden" name="id" value="1" />
					<div class="form-group">
						<div class="label">
							<label for="sitename">网站名称</label>
						</div>
						<div class="field">
							<input type="text" class="input input-auto" id="sitename"
								name="sitename" size="50" placeholder="网站名称"
								value="<?php if( isset($site['sitename'])) echo $site['sitename'] ?>" />

						</div>
					</div>
					<div class="form-group">
						<div class="label">
							<label>网站维护状态</label>
						</div>
						<div class="field">
							<div class="button-group button-group-small radio">
                        	<?php if( isset($site['state'])) : ?>
                            <label
									class="button <?php echo (	$site['state'] =='yes'?'active':'')  ?>">
									<input name="state" value="yes"
										<?php echo ( $site['state'] =='yes'?'checked = "checked"':'')?>
										type="radio">
									<span class="icon icon-check"></span>
									开启
								</label>
								<label class="button <?php echo ( $site['state'] =='no'?'active':'')  ?>">
									<input name="state" value="no" type="radio"
										<?php echo ( $site['state'] =='no'?'checked = "checked"':'') ?>>
									<span class="icon icon-times"></span>
									关闭
								</label>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="label">
							<label for="readme">维护说明</label>
						</div>
						<div class="field">
							<textarea class="input input-auto" name="statedes" rows="5"
								cols="50" placeholder="请填写维护说明"><?php if( isset($site['statedes'])) echo $site['statedes'] ?></textarea>
						</div>
					</div>


					<div class="form-group">
						<div class="label">
							<label for="site_icp">icp备案号</label>
						</div>
						<div class="field">
							<input type="text" class="input input-auto" id="site_icp"
								name="site_icp" size="50" placeholder="icp备案号"
								value="<?php if( isset($site['icp'])) echo $site['icp'] ?>" />
						</div>
					</div>
					<div class="form-group">
						<div class="label">
							<label for="siteurl">网址</label>
						</div>
						<div class="field">
							<input type="text" class="input input-auto" id="siteurl"
								name="siteurl" size="50" placeholder="请填写网址"
								value="<?php if( isset($site['siteurl'])) echo $site['siteurl'] ?>" />
						</div>
					</div>
					<div class="form-group">
						<div class="label">
							<label for="logo">标志</label>
						</div>
						<div class="field">
							<img src="<?php if( isset($site['logo'])) echo $site['logo'] ?>" />
							<a class="button input-file" href="javascript:void(0);">
								+ 浏览文件
								<input size="100" type="file" name="logo" />
							</a>
						</div>
					</div>

					<div class="form-button">
						<button class="button bg-main" type="submit">提交</button>
					</div>
				</form>
			</div>
			<div class="tab-panel" id="tab-email">
				<form method="post" class="form-x"
					action="<?php echo site_url('admin/setting/save') ?>">
					<input type="hidden" name="id" value="2" />
					<div class="form-group">
						<div class="label">
							<label for="address">地址</label>
						</div>
						<div class="field">
							<input type="text" class="input" id="address"
								name="address" size="50" placeholder="地址"
								value="<?php if( isset($contact['address'])) echo $contact['address'] ?>" />
						</div>
					</div>
					<div class="form-group">
						<div class="label">
							<label for="site_tel">电话</label>
						</div>
						<div class="field">
							<input type="text" class="input" id="site_tel" name="site_tel"
								size="50" placeholder="电话"
								value="<?php if( isset($contact['site_tel'])) echo $contact['site_tel'] ?>" />
						</div>
					</div>
					<div class="form-group">
						<div class="label">
							<label for="site_fax">传真</label>
						</div>
						<div class="field">
							<input type="text" class="input" id="site_fax" name="site_fax"
								size="50" placeholder="传真"
								value="<?php if( isset($contact['site_fax'])) echo $contact['site_fax'] ?>" />
						</div>
					</div>
					<div class="form-group">
						<div class="label">
							<label for="site_email">邮箱</label>
						</div>
						<div class="field">
							<input type="text" class="input" id="site_email"
								name="site_email" size="50" placeholder="邮箱"
								value="<?php if( isset($contact['site_email'])) echo $contact['site_email'] ?>" />
						</div>
					</div>
					<div class="form-group">
						<div class="label">
							<label for="site_email">QQ1</label>
						</div>
						<div class="field">
							<input type="text" class="input" id="qq1"
								name="qq1" size="50" placeholder="QQ"
								value="<?php if( isset($contact['qq1'])) echo $contact['qq1'] ?>" />
						</div>
					</div>
					<div class="form-group">
						<div class="label">
							<label for="site_email">QQ2</label>
						</div>
						<div class="field">
							<input type="text" class="input" id="qq2"
								name="qq2" size="50" placeholder="QQ"
								value="<?php if( isset($contact['qq2'])) echo $contact['qq2'] ?>" />
						</div>
					</div>
					<div class="form-button">
						<button class="button bg-main" type="submit">提交</button>
					</div>
				</form>
			</div>
			<div class="tab-panel" id="tab-upload">
				<form method="post" class="form-x"
					action="<?php echo site_url('admin/setting/save') ?>">
					<input type="hidden" name="id" value="3" />
					<div class="form-group">
						<div class="label">
							<label for="title">优化标题</label>
						</div>
						<div class="field">
							<input type="text" class="input" id="title" name="seo_title"
								size="50" placeholder="title标题内容，用于搜索引擎优化"
								value="<?php if( isset($seo['seo_title'])) echo $seo['seo_title'] ?>" />
						</div>
					</div>
					<div class="form-group">
						<div class="label">
							<label for="keywords">关键词</label>
						</div>
						<div class="field">
							<input type="text" class="input" id="keywords"
								name="seo_keywords" size="50" placeholder="站点关键词，用于搜索引擎优化"
								value="<?php if( isset($seo['seo_keywords'])) echo $seo['seo_keywords'] ?>" />
						</div>
					</div>
					<div class="form-group">
						<div class="label">
							<label for="desc">描述</label>
						</div>
						<div class="field">
							<input type="text" class="input" id="desc" name="seo_description"
								size="50" placeholder="网站的描述，用于搜索引擎优化"
								value="<?php if( isset($seo['seo_description'])) echo $seo['seo_description'] ?>" />
						</div>
					</div>
					<div class="form-button">
						<button class="button bg-main" type="submit">提交</button>
					</div>
				</form>
			</div>

		</div>
	</div>

</div>


