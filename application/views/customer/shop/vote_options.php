<ol>
	<?php 
	foreach ($poll_answer as $answer){
		if ($can_vote){
			?>
			<li ><a href="javascript:void(0);" class="exception" onClick="vote(<?php echo $message['poll_id'];?> ,<?php echo $answer['id'];?>, '<?php echo $language;?>');"><span class="vote_answer"><?php echo $answer['answer'.$language_ext];?></span><span class="vote_percentage"><?php echo vote_percentage($answer['vote'], $vote)."%(".$answer['vote'].")";?></span></a></li>
			<?php
		}
		else{
			?>
			<li><span class="vote_answer"><?php echo $answer['answer'.$language_ext];?></span><span class="vote_percentage"><?php echo vote_percentage($answer['vote'], $vote)."%(".$answer['vote'].")";?></span></li>
			<?php
		}
	}
	?>
</ol>