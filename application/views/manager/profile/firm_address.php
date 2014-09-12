<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div id="body_registration">
			<div class="title2">
				Profile - edit firm address
			</div>
			<div id="reg_form">
				<?php 
				echo validation_errors();
				echo form_open("admin/profile/firm_address");
				?>
					<div>
						<label for="name">name</label>
						<input id="name" type="text" name="name" value="<?php echo set_value('name', $profile['firm_name']);?>">
					</div>
					<div>
						<label for="email">e-mail</label>
						<input id="email" type="text" name="email" value="<?php echo set_value('email', $profile['email']);?>">
					</div>
					<div>
						<label for="ico">ico</label>
						<input id="ico" type="text" name="ico" value="<?php echo set_value('ico', $profile['ico']);?>">
					</div>
					<div>
						<label for="street">street</label>
						<input id="street" type="text" name="street" value="<?php echo set_value('street', $profile['street']);?>">
					</div>
					<div>
						<label for="street_number">street number</label>
						<input id="street_number" type="text" name="street_number" value="<?php echo set_value('street_number', $profile['street_number']);?>">
					</div>
					<div>
						<label for="town">city</label>
						<input id="town" type="text" name="town" value="<?php echo set_value('town', $profile['town']);?>">
					</div>
					<div>
						<label for="psc">postal code</label>
						<input id="psc" type="text" name="postal_code" value="<?php echo set_value('postal_code', $profile['postal_code']);?>">
					</div>
					<div>
						<label for="country">country</label>
						<input id="country" type="text" name="country" value="<?php echo set_value('country', $profile['country']);?>">
					</div>
					<div>
					<input type="hidden" name="address_id" value="<?php echo $profile['address_id'];?>" />
						<input type="submit" name="edit" value="edit" />
					</div>
				</form>
			</div>
		</div>
	</div>