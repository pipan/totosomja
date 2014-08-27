<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Links - list
		</div>
		<table>
			<tr>
				<td>page</td>
				<td>block</td>
				<td>position</td>
				<td></td>
			</tr>
			<?php
			foreach($links as $l){
				?>
				<tr>
					<td><?php echo $l['folder'];?></td>
					<td><?php echo $l['block'];?></td>
					<td><?php echo $l['position'];?></td>
					<td><a href = "<?php echo base_url()."index.php/admin/static_page/remove_link/".$l["id"];?>">remove</a></td>
				</tr>
				<?php
			}
			?>
		</table>
	</div>