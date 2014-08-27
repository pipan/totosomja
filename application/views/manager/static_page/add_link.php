<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Links - new
		</div>
		<div>
			<?php
			echo validation_errors();
			echo form_open_multipart("admin/static_page/add_link");
			?>
				<div>
					<label for="page">page</label>
					<select id="block" name="page">
						<?php
						if (isset($page)){ 
							foreach ($page as $p){
								?>
								<option value="<?php echo $p['id'];?>"><?php echo $p['folder'];?></option>
								<?php
							}
						}
						?>
					</select>
				</div>
				<div>
					<label for="block">block</label>
					<select id="block" name="block">
						<?php
						if (isset($block)){ 
							foreach ($block as $b){
								?>
								<option value="<?php echo $b['id'];?>"><?php echo $b['block'];?></option>
								<?php
							}
						}
						?>
					</select>
				</div>
				<div>
					<label for="position">position</label>
					<input id="position" type="text" name="position" value="<?php echo set_value('position');?>" />
				</div>
				<div>
					<input type="submit" name="save" value="save" />
				</div>
			</form>
		</div>
	</div>