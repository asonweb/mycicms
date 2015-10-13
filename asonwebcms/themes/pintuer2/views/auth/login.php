<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <title>智能后台管理-后台管理</title>
    <link rel="stylesheet" href="<?php echo theme_url(); ?>css/pintuer.css">
    <link rel="stylesheet" href="<?php echo theme_url() ?>css/admin.css">
    <script src="<?php echo theme_url() ?>js/jquery.js"></script>
    <script src="<?php echo theme_url() ?>js/pintuer.js"></script>
    <script src="<?php echo theme_url() ?>js/respond.js"></script>
    <script src="<?php echo theme_url() ?>js/admin.js"></script>
</head>
<body>
<div class="container">
    <div class="line">
        <div class="xs6 xm4 xs3-move xm4-move">
        	
            <br /><br />
            <div class="media media-y">
                <a href="<?php echo base_url(); ?>" target="_blank"><img src="<?php echo theme_url() ?>images/logo.png" class="radius" alt="后台管理系统" /></a>
            </div>
            <br /><br />
            <?php if( !empty($message) ):?>
            <div class="alert alert-red"><?php echo $message;?></div>
            <?php endif;?>
            <form action="<?php echo site_url($action_url."/login") ?>" method="post">
            <div class="panel">
                <div class="panel-head"><strong>登录智能后台管理系统</strong></div>
                <div class="panel-body" style="padding:30px;">
                    <div class="form-group">
                        <div class="field field-icon-right">
                            <input type="text" class="input" name="admin" placeholder="登录账号" data-validate="required:请填写账号,length#>=5:账号长度不符合要求" />
                            <span class="icon icon-user"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="field field-icon-right">
                            <input type="password" class="input" name="password" placeholder="登录密码" data-validate="required:请填写密码,length#>=8:密码长度不符合要求" />
                            <span class="icon icon-key"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="field">
                            <input type="text" class="input" name="passcode" placeholder="填写右侧的验证码" data-validate="required:请填写右侧的验证码" />
                            <img src="<?php echo site_url('verifycode/index') ?>" alt="获取新的验证码" style="cursor:pointer" width="80" height="32" class="passcode" onclick="this.src='<?php echo site_url('verifycode/index') ?>'" />
                        	
                        </div>
                    </div>
                    <div class="line">
                    	<div class="x6">
    <?php echo lang('login_remember_label', 'remember');?>
    <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
  </div>
  <div class="x6 text-right"><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></div>
                    </div>
                </div>
                <div class="panel-foot text-center"><button class="button button-block bg-main text-big">立即登录后台</button></div>
            </div>
            </form>
            
        </div>
    </div>
</div>
</body>
</html>