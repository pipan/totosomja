	<div id="body_right">
		<?php 
		if (isset($functions)){
			?>
			<div id="functions">
				<?php 
				foreach ($functions as $f){
					?>
					<div>
						<a href="<?php echo $f['link'];?>"><?php echo $f['text'];?></a>
					</div>
					<?php 
				}
				?>
			</div>
			<?php 
		}
		?>
		<div id="navigator" class="light_blue_bg">
			<div>
				<a href="<?php echo base_url()."index.php/".$language."/profile/edit";?>"><?php echo $lang->line('header_login_edit_profile');?></a>
			</div>
			<div>
				<a href="<?php echo base_url()."index.php/".$language."/profile/orders";?>"><?php echo $lang->line('header_login_orders');?></a>
			</div>
			<div>
				<a href="<?php echo base_url()."index.php/".$language."/profile/wishlist";?>"><?php echo $lang->line('header_login_wishlist');?></a>
			</div>
			<div>
				<a href="<?php echo base_url()."index.php/".$language."/login/logout";?>"><?php echo $lang->line('header_login_logout');?></a>
			</div>
		</div>
	</div>
</div>