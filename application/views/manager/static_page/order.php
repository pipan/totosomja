<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Links - list
		</div>
		<?php
		echo validation_errors();
		echo form_open("admin/static_page/order_page");
			if (isset($links)){
				$prev_block_id = 0;
				foreach($links as $l){
					if ($l['block_id'] != $prev_block_id){
						?>
						<div>
							<?php echo $l['block'];?>
						</div>
						<?php
					}
					?>
					<div>
						<label for="<?php echo "position_".$l['id'];?>"><?php echo $l['folder'];?></label>
						<input id="<?php echo "position_".$l['id'];?>" type="text" name="<?php echo "position_".$l['id'];?>" value="<?php echo set_value("position_".$l['id'], $l['position']);?>" />
					</div>
					<?php
					$prev_block_id = $l['block_id'];
				}
			}
			?>
			<div>
				<input type="submit" name="save" value="save" />
			</div>
		</form>
	</div>