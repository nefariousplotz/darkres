	<?php
	
		// Figure out who's blockable and unblock everybody
		
		include "block_getlist.php";
		include "unblock.php";
	
		// Randomly sort the array (to break ties later)
		shuffle($blockable);
	
		// Sort the array of blockable candidates by stars
		$columns = array_column($blockable,'blockablestars');
		array_multisort($columns,SORT_DESC,$blockable);
				
		// Block whoever has the most stars
		
		$blockedcontestant = $blockable[0]['blockableid'];
		
				
		if ($blockedcontestant != -1) {
			$contestantarray[$blockedcontestant]["blocked"] = 1; 
		}
			
	?>