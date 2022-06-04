	<?php
	
	// Figure out who's blockable and unblock everybody
		
		include "block_getlist.php";
		include "unblock.php";
		
	// Next, rank them in order of stars to date.
	
	$columns = array_column($blockable,'blockablestars');
	array_multisort($columns,SORT_DESC,$blockable);
	
	// Next, determine if there's a tie for first place.
	
	$topstars = $blockable[0]["blockablestars"];
	
	$topcontestants = array_count_values(array_column($blockable, "blockablestars"))[$topstars];
	
	if ($topcontestants == 1) {
		$blockedcontestant = $blockable[0]["blockableid"];
	} else {
		$blockedpull = rand(1,$topcontestants)-1;
		$blockedcontestant = $blockable[$blockedpull]["blockableid"];
	}
	
	
	// Block 'em.
	
	$contestantarray[$blockedcontestant]["blocked"] = 1;
	
	?>