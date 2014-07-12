<div id="body">
	<div id="body_left" class="light_blue_bg_transparent">
		<div class="product_body_column">
			<div class="product_body_item_border"> 
				<div class="product_body_item_border_image_body">
					<img class="product_body_item_border_image" src="<?php echo base_url()."content/product/image/".$shirt['product_image'];?>" />
				</div>
			</div>
		</div>
		<div class="product_body_column">
			<div class="product_body_item_info"> 
				<div class="title2">
					<?php echo $shirt['product_name'];?>
				</div>
				<div class="product_body_item_info_block">
					<div class="product_body_item_info_line"> 
						<div class="product_body_item_info_label">
							Typ
						</div>
						<div class="product_body_item_info_value">
							<?php echo gender_to_string($shirt["gender"]);?>
						</div>
					</div>
					<div class="product_body_item_info_line"> 
						<div class="product_body_item_info_label">
							Velkost
						</div>
						<div class="product_body_item_info_value">
							<?php echo $shirt['size_name'];?>
						</div>
					</div>
					<div class="product_body_item_info_line"> 
						<div class="product_body_item_info_label">
							Farba
						</div>
						<div class="product_body_item_info_value">
							<?php echo $shirt['color_name'];?>
						</div>
					</div>
				</div>
				<div class="product_body_item_info_block">
					<div class="product_body_item_info_line"> 
						<div class="product_body_item_info_label">
							Cena
						</div>
						<div class="product_body_item_info_value title2">
							<?php echo $shirt["price"]." EUR";?>
						</div>
					</div>
				</div>
				<div class="product_body_item_info_block">
					<div class="product_body_item_info_line"> 
						<div class="product_body_item_info_label">
							Po&#269;et ks
						</div>
						<div class="product_body_item_info_value">
							<select name="pieces" class="dark_exception">
							<?php
							for ($i = 0; $i <= 10; $i++){
								?>
								<option><?php echo $i;?></option>
								<?php
							}
							?>
							</select>
						</div>
					</div>
					<div class="product_body_item_info_line"> 
						<div class="product_body_item_info_label">
							Dostupnos&#357;
						</div>
						<div class="product_body_item_info_value">
							<?php echo store_to_string($shirt["store"]);?>
						</div>
					</div>  
				</div>
			</div>
		</div>
		<div class="product_body_padding" style="clear:both;">
			<div>
				<?php 
				if (!$wish){
					?>
					<input type="button" name="pridat do wishlistu" value="wishlist" onClick="redirect('<?php echo base_url()."index.php/".$language."/shirt/wish/".$shirt['product_slug'];?>')" />
					<?php
				}
				?>
				<input type="button" name="kupis" value="kupit" />
			</div>
			<div>
				<?php echo read_file("./content/product/description/".$shirt['id'].".txt");?>
			</div>
		</div>
		<?php 
		if ($login != false){
			?>
			<div class="product_body_padding white_bg_transparent">
				<div id="new_comment">
					<?php 
					if ($show_error){
						echo validation_errors();
					}
					echo form_open($language."/shirt/".$shirt['product_slug']);
					?>
						<div>
							<textarea name="comment"><?php
							if ($show_error){
								echo set_value('comment');
							}?></textarea>
						</div>
						<div>
							<input type="hidden" name="blog_id" value="<?php echo $shirt['id'];?>" />
							<input type="submit" name="send" value="<?php echo $lang->line('product_comment_send_button');?>" />
						</div>
					</form>
				</div>
			</div>
			<?php
		}
		else{
			?>
			<div class="product_body_padding">
				Hodnotit mozu len registrovany zakaznici
			</div>
			<?php
		}
		foreach ($comments as $c){
			?>
			<div class="product_body_padding white_bg_transparent">
				<div class="comment">
					<div class="comment_header gray">
						<div class="comment_header_name">
							<?php echo $c['customer_nickname'];?>
						</div>
						<div class="comment_header_date">
							<?php echo date_to_word($language, $c['post_date']);?>
						</div>
					</div>
					<div class="comment_body">
						<?php echo read_file("./content/product/comments/".$c['id'].".txt");?>
					</div>
				</div>
			</div>
			<?php	
		}
		?>
	</div>