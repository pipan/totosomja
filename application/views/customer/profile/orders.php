<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			<?php echo $lang->line('orders_title');?>
		</div>
		<div>
			<?php 
			foreach ($invoic as $i){
				?>
				<div class="wish light_blue_bg_transparent">
					<div class="wish_body">
						<div class="wish_title title3">
							<a href="<?php echo base_url()."index.php/".$language."/orders/view/".$i['id'];?>" target="_blank"><?php echo $lang->line('invoic_number')." ".$i['invoic_id'];?></a><span style="font-weight: normal;"><?php echo " | ".$i['status_name'.$language_ext];?></span>
						</div>
						<div class="wish_date">
							<?php echo date_to_word($language, $i['transaction_date']);?>
						</div>
					</div>
					<?php 
					if (isset($i['products'])){
						foreach ($i['products'] as $p){
							?>
							<div class="wish_image_body_large">
								<div>
									<div class="wish_image_body_quantity title1">
										<?php echo $p['quantity']."x";?>
									</div>
									<div>
										<img class="wish_image" src="<?php echo base_url()."content/product/image/".$p['product_image'];?>" alt="<?php echo $p['product_name'.$language_ext];?>"/>
									</div>
								</div>
								<div class="wish_image_body_title">
									<?php echo $p['product_name'.$language_ext];?>
								</div>
							</div>
							<?php
						}
					}
					?>
				</div>
				<?php
			}
			?>
		</div>
	</div>