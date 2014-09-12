<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			totosomja - paypal
		</div>
		<div>
		<?php 
		if (isset($ipn)){
			foreach ($ipn as $tmp){
				?>
				<div>
					<a href="<?php echo $tmp['link']?>" target="_blank"><?php echo $tmp['name'];?></a>
				</div>
				<?php
			}
		}
		?>
		</div>
	</div>
	