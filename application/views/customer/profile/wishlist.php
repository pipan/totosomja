<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			<?php echo $lang->line('wishlist_title');?>
		</div>
		<div>
			<?php 
			foreach ($wish as $w){
				?>
				<div class="wish light_blue_bg_transparent">
					<div class="wish_image_body">
						<img class="wish_image" src="<?php echo base_url()."content/product/image/".$w['product_image'];?>"/>
					</div>
					<div class="wish_body">
						<div class="wish_title title3">
							<a href="<?php echo base_url()."index.php/".$language."/shirt/".$w['product_slug'.$language_ext];?>"><?php echo $w['product_name'.$language_ext];?></a>
						</div>
						<div class="wish_date">
							<?php echo date_to_word($language, $w['wish_date']);?>
						</div>
						<div class="wish_functions">
							<div class="wish_function_remove">
								<a href="<?php echo base_url()."index.php/".$language."/profile/remove_wish/".$w['product_id'];?>"><?php echo $lang->line('wishlist_remove');?></a>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>