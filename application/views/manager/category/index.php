<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Category - list
		</div>
		<table>
			<tr>
				<td>name</td>
				<td>image</td>
				<td>description</td>
				<td>change</td>
				<td>create simular</td>
			</tr>
			<?php
			foreach($category as $c){
				?>
				<tr>
					<td><?php echo $c["category_name"];?></td>
					<td><img style="width:100px;" src="<?php echo content_url()."category/image/".$c["category_image"];?>" /></td>
					<td><?php echo read_file("./content/category/description/".$c['id'].".txt");?></td>
					<td><a href = "<?php echo base_url()."index.php/admin/category/edit/".$c["id"];?>">change</a></td>
					<td><a href = "<?php echo base_url()."index.php/admin/category/new_cateogyr/".$c["id"];?>">simular</a></td>
				</tr>
				<?php
			}
			?>
		</table>
	</div>