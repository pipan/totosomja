<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Color - list
		</div>
		<table>
			<tr>
				<td>name</td>
				<td>name en</td>
				<td></td>
			</tr>
			<?php
			foreach($color as $c){
				?>
				<tr>
					<td><?php echo $c["color_name"];?></td>
					<td><?php echo $c["color_name_en"];?></td>
					<td><a href="<?php echo base_url()."index.php/admin/color/edit/".$c["id"];?>"><img src="<?php echo assets_url()."images/update_logo.png";?>" />change</a></td>
				</tr>
			<?php
			}
			?>
		</table>	
	</div>
		