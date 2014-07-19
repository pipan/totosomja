<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Size - list
		</div>
		<table>
			<tr>
				<td>name</td>
				<td>name_en</td>
				<td></td>
			</tr>
			<?php
			foreach($size as $s){
				?>
				<tr>
					<td><?php echo $s["size_name"];?></td>
					<td><?php echo $s["size_name_en"];?></td>
					<td><a href = "<?php echo base_url()."index.php/admin/size/edit/".$s["id"];?>"><img src="<?php echo assets_url()."images/update_logo.png";?>" />change</a></td>
				</tr>
				<?php
			}
			?>
		</table>
	</div>