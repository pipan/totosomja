<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Category - list
		</div>
		<table>
			<tr>
				<td>name</td>
				<td>name en</td>
				<td>image</td>
				<td>description</td>
				<td></td>
			</tr>
			<?php
			foreach($category as $c){
				?>
				<tr>
					<td><?php echo $c["category_name"];?></td>
					<td><?php echo $c["category_name_en"];?></td>
					<td><img style="width:100px;" src="<?php echo content_url()."category/image/".$c["category_image"];?>" /></td>
					<td><?php echo read_file("./content/category/description/".$c['id'].".txt");?></td>
					<td><a href = "<?php echo base_url()."index.php/admin/category/edit/".$c["id"];?>"><img src="<?php echo assets_url()."images/update_logo.png";?>" />change</a></td>
				</tr>
				<?php
			}
			?>
		</table>
	</div>