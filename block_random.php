	<?php
	
	// Figure out who's blockable and unblock everybody
		
	include "block_getlist.php";
	include "unblock.php";
	
	// Select someone at random
	
	$blockedcontestant = $blockable[array_rand($blockable)]["blockableid"];
	
	// Block 'em.
	
	$contestantarray[$blockedcontestant]["blocked"] = 1;
	
	?>