<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Message - list
		</div>
		<table>
			<tr>
				<td>creator</td>
				<td>title</td>
				<td>poll</td>
				<td>post date</td>
				<td></td>
			</tr>
			<?php
			foreach($message as $m){
				?>
				<tr>
					<td><?php echo $m['admin_name']." ". $m['admin_surname'];?></td>
					<td><?php echo $m['message_name'];?></td>
					<?php 
					if ($m['poll_id'] != null){
						?>
						<td><?php echo $m['question']?></td>
						<?php 
					}
					else{
						?>
						<td>None</td>
						<?php 
					}
					?>
					<td><?php echo $m['post_date']?></td>
					<td><a href = "<?php echo base_url()."index.php/admin/message/edit/".$m["id"];?>"><img src="<?php echo assets_url()."images/update_logo.png";?>" />change</a></td>
				</tr>
				<?php
			}
			?>
		</table>
	</div>