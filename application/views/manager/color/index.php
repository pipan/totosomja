<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Color - list
		</div>
		<table>
			<tr>
				<td>name</td>
				<td>change</td>
			</tr>
			<?php
			foreach($color as $c){
				?>
				<tr>
					<td><?php echo $c["color_name"];?></td>
					<td><a href="<?php echo base_url()."index.php/admin/color/edit/".$c["id"];?>">change</a></td>
				</tr>
			<?php
			}
			?>
		</table>	
	</div>
		