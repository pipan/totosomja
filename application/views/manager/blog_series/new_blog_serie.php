<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Blog serie - new
		</div>
		<div>
			<?php
			echo validation_errors();
			echo form_open_multipart("admin/blog_series/new_blog_serie");
			?>
				<div>
					<label for="serie_name">name</label>
					<input id="serie_name" type="text" name="name" value="<?php echo set_value('name');?>" />
				</div>
				<div>
					<input type="submit" name="add" value="add" />
				</div>
			</form>
		</div>
	</div>