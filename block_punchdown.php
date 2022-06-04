	<?php
	
	// Figure out who's blockable and unblock everybody
		
	include "block_getlist.php";
	include "unblock.php";
		
	// Next, rank them in order of stars to date.
	
	$columns = array_column($blockable,'blockablestars');
	array_multisort($columns,SORT_DESC,$blockable);
	
	// Next, determine where the blocker is currently situated.
	
	$winnerstars = $contestantarray[$winnerid]["starcount"];
	
	unset($punchdownarray);
	
	$punchdownarray = $blockable;
	
	foreach($punchdownarray as $candidateid => $candidatevalue) {
			if ($winnerstars < $candidatevalue["blockablestars"]) {
					unset ($punchdownarray[$candidateid]);
			}
	}

	if (count($punchdownarray) == 0) {
		// If nobody has fewer stars than the winner, pick someone at random.
		include "block_random.php";
		$strategyverb = "can't punch down, so picks at random instead";
	} else {
		// If somebody does have fewer stars, select at random from among the survivors.
		array_values($punchdownarray);
		$maxpull = count($punchdownarray)-1;
		$blockedpull = rand(0,$maxpull);
		$blockedcontestant = $blockable[$blockedpull]["blockableid"];
	}
	
	$contestantarray[$blockedcontestant]["blocked"] = 1;
	
	?>