<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>欢迎您登录美中国际</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<!-- basic styles -->

		<link href="/my/tk-xm/usaedu/Public/Statics/Admin/assets/css/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="/my/tk-xm/usaedu/Public/Statics/Admin/assets/css/font-awesome.min.css" />

		<!--[if IE 7]>
		  <link rel="stylesheet" href="/my/tk-xm/usaedu/Public/Statics/Admin/assets/css/font-awesome-ie7.min.css" />
		<![endif]-->

		<!-- page specific plugin styles -->

		<!-- ace styles -->

		<link rel="stylesheet" href="/my/tk-xm/usaedu/Public/Statics/Admin/assets/css/ace.min.css" />
		<link rel="stylesheet" href="/my/tk-xm/usaedu/Public/Statics/Admin/assets/css/ace-rtl.min.css" />

		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="/my/tk-xm/usaedu/Public/Statics/Admin/assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="/my/tk-xm/usaedu/Public/Statics/Admin/assets/js/html5shiv.js"></script>
		<script src="/my/tk-xm/usaedu/Public/Statics/Admin/assets/js/respond.min.js"></script>
		<![endif]-->
		<script type="text/javascript">
			var URL='<?php echo U('Public/verify','','');?>'+'/';
			
			function change_code(obj){
				$("#code").attr("src",URL+Math.random());
				return false;
			}		
		</script>
	</head>

	<body class="login-layout">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h1>
									<i class="icon-leaf green"></i>
									<span class="red">Usaedu</span>
									<span class="white">美中国际</span>
								</h1>
								<h4 class="blue">&copy; Usaedu</h4>
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header blue lighter bigger">
												<i class="icon-coffee green"></i>
												请登陆你的用户
											</h4>

											<div class="space-6"></div>

											<form action="<?php echo U('Public/checkLogin');?>" method="post">
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" name="username" class="form-control" placeholder="请填写用户名" autocomplete="off" />
															<i class="icon-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" name="password" class="form-control" placeholder="请填写密码" autocomplete="off" />
															<i class="icon-lock"></i>
														</span>
													</label>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" name="verify" class="form-control" placeholder="请填写验证码" autocomplete="off">
															<i class="icon-lock"></i><a class="reloadverify" title="换一张" href="javascript:void(change_code(this));">换一张？</a>
														</span>
													</label>
													
													
													<div class="space"></div>

													<div class="clearfix">
														<button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
															<i class="icon-key"></i>
															Login
														</button>
													</div>

													<div class="space-4"></div>
												</fieldset>
											</form>

											<div class="social-or-login center">
												<span class="bigger-110">验证码</span>
											</div>

											<div class="social-login center">
												<img  id="code" alt="点击切换" onclick="javascript:void(change_code(this));" src="<?php echo U('Public/verify','','');?>">
											</div>
										</div><!-- /widget-main -->

										<div class="toolbar clearfix">
											<div>
												
											</div>

											<div>
												
											</div>
										</div>
									</div><!-- /widget-body -->
								</div><!-- /login-box -->
							</div><!-- /position-relative -->
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->

		<script src="/my/tk-xm/usaedu/Public/Statics/Admin/assets/js/jquery-2.0.3.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
		<script src="/my/tk-xm/usaedu/Public/Statics/Admin/assets/js/jquery-1.10.2.js"></script>
<![endif]-->

		<!--[if !IE]> -->

		<script type="text/javascript">
			window.jQuery || document.write("<script src='/my/tk-xm/usaedu/Public/Statics/Admin/assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
		<script type="text/javascript">
		 window.jQuery || document.write("<script src='/my/tk-xm/usaedu/Public/Statics/Admin/assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
		</script>
		<![endif]-->

		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='/my/tk-xm/usaedu/Public/Statics/Admin/assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
</body>
</html>