				<div id="footer">
					<div id="footer_navigator">
						<div style="padding-top:2px;">
							<?php 
							if (isset($footer)){
								foreach ($footer as $f){
									?>
									<div class="header_navigator_item">
										<a href="<?php echo base_url()."index.php/".$language."/".$f['page_slug'.$language_ext];?>"><?php echo $f['page_title'.$language_ext];?></a>
									</div>
									<?php
								}
							}
							?>
							<!-- 
							<div class="header_navigator_item">
								<a href=""><?php echo $lang->line('footer_about');?></a>
							</div> 
							<div class="header_navigator_item">
								<a href="<?php echo base_url()."index.php/".$language."/kontakt";?>"><?php echo $lang->line('footer_contact');?></a>
							</div> 
							<div class="header_navigator_item">
								<a href=""><?php echo $lang->line('footer_sales_condition');?></a>
							</div> 
							<div class="header_navigator_item">
								<a href=""><?php echo $lang->line('footer_privacy_policy');?></a>
							</div>
							 -->
						</div>
					</div>
					<div id="footer_copyright">
						<div>
							<?php echo $lang->line('footer_copyright');?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>