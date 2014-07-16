<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Supplier - list
		</div>
		<table>
			<tr>
				<td>name</td>
				<td>delivery</td>
				<td></td>
			</tr>
			<?php
			foreach ($supplier as $s){
				?>
				<tr>
					<td><?php echo $s["supplier_name"];?></td>
					<td>
					<?php
					$delivery = delivery_to_form_text($s["supplier_delivery"]);
					echo $delivery[0]." ".$delivery[1];
					?>
					</td>
					<td><a href="<?php echo base_url()."index.php/admin/supplier/edit/".$s["id"];?>"><img src="<?php echo assets_url()."images/update_logo.png";?>" />change</a></td>
				</tr>
				<?php
			}
			?>
		</table>
	</div>