	<div id="body_right">
		<div id="navigator" class="light_blue_bg">
			<?php
			$year = 0; 
			$i = 0;
			if (isset($year_list)){
				foreach ($year_list as $list){
					$explode = explode('-', $list['month_year']);
					if ($explode[1] != $year){
						if ($year != 0){
							?>
							</ul>
							<?php
						}
						$year = $explode[1];
						?>
						<div><?php echo $year;?></div>
						<ul class="exception">
						<?php 
					} 
					?>
					<li class="clickable" onClick="toggleVisibility('<?php echo "#nav_".$list['month_year'];?>');"><?php echo $lang->line('month_'.($explode[0] - 1));?></li>
					<ul id="nav_<?php echo $list['month_year'];?>" style="display: none;">
					<?php
					while ($i < sizeof($blog_navigator) && $blog_navigator[$i]['month_year'] == $list['month_year']){
						?>
						<li><a href="<?php echo base_url()."index.php/".$language."/blog/".$blog_navigator[$i]['slug'.$language_ext];?>" class="exception"><?php echo $blog_navigator[$i]['title'.$language_ext];?></a></li>
						<?php
						$i++;
					}
					?>
					</ul>
					<?php
				}
				if ($year != 0){
					?>
					</ul>
					<?php
				}
			}
			?>
		</div>
	</div>
</div>