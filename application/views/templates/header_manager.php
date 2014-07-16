<!doctype html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="<?php echo assets_url();?>style/style_general.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo assets_url();?>style/style_admin.css" />
		<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="<?php echo assets_url();?>jscript/jscript_general.js"></script>
		<script type="text/javascript" src="<?php echo assets_url();?>jscript/jscript_editor.js"></script>
		<?php 
		if (isset($jscript)){
			foreach ($jscript as $j){
				?>
				<script type="text/javascript" src="<?php echo assets_url()."jscript/".$j.".js";?>"></script>
				<?php
			}
		}
		?>
		<script type="text/javascript" src="<?php echo assets_url();?>jscript/jquery_general.js"></script>
		<!--<script type="text/javascript" src="<?php echo assets_url();?>jscript/jscript_blog.js"></script> -->
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<title>
			<?php echo $title;?>
		</title>
	</head>
	<body>
		<div id="background">
			<div id="background_image">
			</div>
		</div>
		<div id="main">
			<div id="main_center">
				<div id="header">
					<div id="header_title">
						<a href="<?php echo base_url();?>index.php/admin/manager">
							<div id="header_logo">
							
							</div>
						</a>
						<div id="header_login">
							<div class="header_login_item">
								<a href="<?php echo base_url();?>index.php/admin/manager/logout">logout</a>
							</div>
						</div>
					</div>
					<div id="header_navigator">
						<div style="overflow:hidden; margin-left:102px;">
							<div class="header_navigator_item">
								<a href="<?php echo base_url()."index.php/admin/manager";?>">totosomja</a>
							</div>
							<div class="header_navigator_item">
								<a href="<?php echo base_url()."index.php/admin/product";?>">tri&#269;k&aacute;</a>
							</div>
							<div class="header_navigator_item">
								<a href="<?php echo base_url()."index.php/admin/blog";?>">blog</a>
							</div>
							<div class="header_navigator_item">
								<a href="<?php echo base_url()."index.php/admin/profile";?>">admin profil</a>
							</div>
							<div class="header_navigator_item">
								<a href="<?php echo base_url()."index.php/admin/message";?>">message/poll</a>
							</div>
						</div>
					</div>
					
				</div>