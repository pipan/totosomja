<div id="body">
	<div id="body_left" class="white_bg_transparent">
		<div class="title2">
			Order - list
		</div>
		<table>
			<tr>
				<td>invoic id</td>
				<td>name</td>
				<td>surname</td>
				<td>payment status</td>
				<td>status</td>
				<td></td>
				<td></td>
			</tr>
			<?php
			foreach ($invoic as $i){
				?>
				<tr>
					<td><?php echo $i['invoic_id'];?></td>
					<td><?php echo $i['buyer_name'];?></td>
					<td><?php echo $i['buyer_surname'];?></td>
					<td><?php echo $i['payment_status'];?></td>
					<td><?php echo $i['status_name'];?></td>
					<td class="center"><a href = "<?php echo base_url()."index.php/admin/orders/edit/".$i['id'];?>"><img src="<?php echo assets_url()."images/change_logo.png";?>" />edit</a></td>
					<td class="center"><a href = "<?php echo base_url()."index.php/admin/orders/products/".$i['id'];?>">products</a></td>
				</tr>
				<?php
			}
			?>
		</table>
	</div>