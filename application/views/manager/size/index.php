<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Size - list
		</div>
		<table>
			<tr>
				<td>name</td>
				<td>change</td>
			</tr>
			<?php
			foreach($size as $s){
				?>
				<tr>
					<td><?php echo $s["size_name"];?></td>
					<td><a href = "<?php echo base_url()."index.php/admin/size/edit/".$s["id"];?>">change</a></td>
				</tr>
				<?php
			}
			?>
		</table>
	</div>