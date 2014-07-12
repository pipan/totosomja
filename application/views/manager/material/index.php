<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Material - list
		</div>
		<table>
			<tr>
			<td>name</td>
			<td>change</td>
			</tr>
			<?php
			foreach($material as $m){
				?>
				<tr>
					<td><?php echo $m["material_name"];?></td>
					<td><a href = "<?php echo base_url()."/index.php/admin/material/edit/".$m["id"];?>">change</a></td>
				</tr>
				<?php
			}
			?>
		</table>
	</div>