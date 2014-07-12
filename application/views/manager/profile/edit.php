<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div id="body_registration">
			<div class="title2">
				Profile - edit
			</div>
			<div id="reg_form">
				<?php 
				echo validation_errors();
				echo form_open("admin/profile");
				?>
					<div>
						<label for="admin_name">name</label>
						<input id="admin_name" type="text" name="admin_name" value="<?php echo set_value('admin_name', $profile['admin_name']);?>">
					</div>
					<div>
						<label for="admin_surname">surname</label>
						<input id="admin_surname" type="text" name="admin_surname" value="<?php echo set_value('admin_surname', $profile['admin_surname']);?>">
					</div>
					<div>
						<label for="admin_email">e-mail</label>
						<input id="admin_email" type="text" name="admin_email" value="<?php echo set_value('admin_email', $profile['admin_email']);?>">
					</div>
					<div>
						<input type="submit" name="edit" value="edit" />
					</div>
				</form>
			</div>
		</div>
	</div>