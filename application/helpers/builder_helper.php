<?php
if (!function_exists("page_div")){
	function page_div($page, $offset, $max, $link, $base = false){
		$from = $page - $offset;
		if ($from < 1){
			$from = 1;
		}
		$to = $page + $offset;
		if ($to > $max){
			$to = $max;
		}
		?>
		<div id="pages">
			<?php 
			if ($base && $from > 1){
				$link_complete = str_replace("%p", "1", $link);
				?>
				<div class="page_number">
					<a class="exception" href="<?php echo $link_complete;?>">1</a>
				</div>
				<?php
			}
			for ($i = $from; $i <= $to; $i++){
				$link_complete = str_replace("%p", $i, $link);
				?>
				<div class="page_number">
					<?php
					if ($i == $page){
						?>
						<a href="<?php echo $link_complete;?>"><?php echo $i;?></a>
						<?php 
					}
					else{
						?>
						<a class="exception" href="<?php echo $link_complete;?>"><?php echo $i;?></a>
						<?php
					}
					?>
				</div>
				<?php	
			}
			if ($base && $to < $max){
				$link_complete = str_replace("%p", $max, $link);
				?>
				<div class="page_number">
					<a class="exception" href="<?php echo $link_complete;?>"><?php echo $max;?></a>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	}
}

if (!function_exists("select_fomr")){
	function select_form($select_id, $select_name, $data, $id_field, $name_field, $lang, $select = 0, $class= "" ){
		?>
		<select id="<?php echo $select_id;?>" class="<?php echo $class;?>" name="<?php echo $select_name;?>">
			<option value=""><?php echo $lang->line('form_none');?></option>
			<?php
			foreach ($data as $d){
				if ($select == $d[$id_field]){
					?>
					<option value="<?php echo $d[$id_field];?>" selected="<?php echo $d[$name_field];?>"><?php echo $d[$name_field];?></option>
					<?php
				}
				else{
					?>
					<option value="<?php echo $d[$id_field];?>"><?php echo $d[$name_field];?></option>
					<?php 
				}	
			}
		?>
		</select>
		<?php	
	}	
}