<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Material - list
		</div>
		<table>
			<tr>
				<td>name</td>
				<td>name en</td>
				<td></td>
			</tr>
			<?php
			foreach($material as $m){
				?>
				<tr>
					<td><?php echo $m["material_name"];?></td>
					<td><?php echo $m["material_name_en"];?></td>
					<td><a href = "<?php echo base_url()."/index.php/admin/material/edit/".$m["id"];?>"><img src="<?php echo assets_url()."images/update_logo.png";?>" />change</a></td>
				</tr>
				<?php
			}
			?>
		</table>
	</div>