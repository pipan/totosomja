<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Type - list
		</div>
		<table>
			<tr>
				<td>name</td>
				<td>image</td>
				<td>description</td>
				<td></td>
			</tr>
		<?php
		foreach($type as $t){
			?>
			<tr>
				<td><?php echo $t["type_name"];?></td>
				<td><img style="width: 100px;" src="<?php echo content_url()."type/image/".$t["type_image"];?>" /></td>
				<td><?php echo read_file("./content/type/description/".$t["id"].".txt");?></td>
				<td><a href = "<?php echo base_url()."index.php/admin/type/edit/".$t["id"];?>"><img src="<?php echo assets_url()."images/update_logo.png";?>" />change</a></td>
			</tr>
			<?php
		}
		?>
		</table>
	</div>