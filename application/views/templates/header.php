<!doctype html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="<?php echo assets_url();?>style/style_general.css" />
		<?php 
		if (isset($style)){
			foreach ($style as $s){
				?>
				<link rel="stylesheet" type="text/css" href="<?php echo assets_url()."style/".$s.".css";?>" />
				<?php
			}	
		}
		?>
		<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="<?php echo assets_url();?>jscript/jscript_general.js"></script>
		<script type="text/javascript" src="<?php echo assets_url();?>jscript/jscript_product_filter.js"></script>
		<script type="text/javascript" src="<?php echo assets_url();?>jscript/jquery_general.js"></script>
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
				<div id="language">
					<?php 
					foreach ($lang_label as $label){
						?>
						<div class="language_label">
							<a class="<?php echo $label['class'];?>" href="<?php echo $label['link'];?>"><?php echo $label['text'];?></a>
						</div>
						<?php 
					}
					?>
				</div>
				<div id="header">
					<div id="header_title" style="overflow: visible;">
						<a href="<?php echo base_url()."index.php/".$language;?>">
							<div id="header_logo">
							
							</div>
						</a>
						<div id="header_login">
							<div class="header_login_item">
								<form id="paypal_view_cart" target="paypal" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
									<input type="hidden" name="cmd" value="_cart">
									<input type="hidden" name="business" value="totosomja@mail.com">
									<!--
									<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_viewcart_LG.gif" border="0" name="submit" alt="">
									<img alt="" border="0" src="https://www.paypal.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
									-->
									<a href="javascript:void(0);" onClick="submitForm('#paypal_view_cart');"><?php echo $lang->line('header_cart');?></a>
									<INPUT type="hidden" name="noshipping" value="0">
									<input type="hidden" name="display" value="1">
								</form>
							</div>
							<div class="header_login_item" style="overflow: visible;min-width: 200px;">
								<?php
								if ($login != false){
									?>
									<div style="float: right;" onMouseover="show('#header_login_menu');" onMouseout="hide('#header_login_menu');">
									<a href="javascript:void(0);">
									<?php
									echo $login['nickname'];
									?>
									</a>
										<div id="header_login_menu">
											<div class="header_login_menu_item">
												<a href="<?php echo base_url()."index.php/".$language."/profile/edit"?>"><?php echo $lang->line('header_login_edit_profile');?></a>
											</div>
											<div class="header_login_menu_item">
												<a href=""><?php echo $lang->line('header_login_orders');?></a>
											</div>
											<div class="header_login_menu_item">
												<a href="<?php echo base_url()."index.php/".$language."/profile/wishlist"?>"><?php echo $lang->line('header_login_wishlist');?></a>
											</div>
											<div class="header_login_menu_item">
												<a href="<?php echo base_url()."index.php/".$language."/login/logout"?>"><?php echo $lang->line('header_login_logout');?></a>
											</div>
										</div>
									</div>
									<?php
								}
								else{
									?>
									<a href="<?php echo base_url()."index.php/".$language."/login";?>">
									<?php
									echo $lang->line('header_login');
									?>
									</a>
									<?php
								}
								?>
							</div>
						</div>
					</div>
					<div id="header_navigator">
						<div style="overflow:hidden; margin-left:102px;">
							<div class="header_navigator_item">
								<a href="<?php echo base_url()."index.php/".$language;?>"><?php echo $lang->line('header_index');?></a>
							</div>
							<div class="header_navigator_item">
								<a href="<?php echo base_url()."index.php/".$language."/shirt";?>"><?php echo $lang->line('header_t_shirt');?></a>
							</div>
							<div class="header_navigator_item">
								<a href=""><?php echo $lang->line('header_more');?></a>
							</div>
							<div class="header_navigator_item">
								<a href=""><?php echo $lang->line('header_about');?></a>
							</div>
							<div class="header_navigator_item">
								<a href="<?php echo base_url()."index.php/".$language."/newsletter";?>"><?php echo $lang->line('header_newsletter');?></a>
							</div>
							<div class="header_navigator_item">
								<a href="<?php echo base_url()."index.php/".$language."/blog";?>"><?php echo $lang->line('header_blog');?></a>
							</div>
						</div>
					</div>
					
				</div>