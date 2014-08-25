<div id="body">
	<div id="body_left" class="light_blue_bg_transparent">
		<div class="product_body_column">
			<?php 
			$i = 1;
			foreach ($shirt as $s){
				?>
				<div class="product_preview">
					<a href="<?php echo base_url()."index.php/".$language."/shirt/".$s['product_slug'.$language_ext];?>">
						<div class="product_body_item_border white_bg_transparent"> 
							<div class="product_body_item_border_image_body">
								<img class="product_body_item_border_image" src="<?php echo base_url()."content/product/image/".$s['product_image'];?>" />
							</div>
							<div class="product_body_item_border_name">
								<a href="<?php echo base_url()."index.php/".$language."/shirt/".$s['product_slug'.$language_ext];?>"><?php echo $s['product_name'.$language_ext];?></a>
							</div>
						</div>
					</a>
				</div>
				<?php
				if ($i % ($limit / 2) == 0){
					?>
					</div>
					<div class="product_body_column">
					<?php
				}
				$i++;
			} 
			?>
		</div>
		<?php
		page_div($page, $page_offset, $last_page, base_url()."index.php/".$language."/shirt/%p");
		?>
	</div>