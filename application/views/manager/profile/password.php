<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div id="body_registration">
			<div class="title2">
				Profile - password
			</div>
			<div id="reg_form">
				<?php 
				echo validation_errors();
				echo form_open("admin/profile/password");
				?>
					<div>
						<label for="profile_old_password">old password</label>
						<input id="profile_old_password" type="password" name="old_password" />
					</div>
					<div>
						<label for="profile_new_password">new password</label>
						<input id="profile_new_password" type="password" name="new_password" />
					</div>
					<div>
						<label for="profile_new_password_repeat">repeat new password</label>
						<input id="profile_new_password_repeat" type="password" name="new_password_repeat" />
					</div>
					<div>
						<input type="submit" name="change" value="change" />
					</div>
				</form>
			</div>
		</div>
	</div>