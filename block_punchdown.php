	<?php
	
		// Figure out who's blockable and unblock everybody
		
		include "block_getlist.php";
		include "unblock.php";
	
		// Randomly sort the array (to break ties later)
		shuffle($blockable);
		
		// Create a new candidate array so that we don't bork the blockable array
		$winnerstars = $contestantarray[$winners[0]]["starcount"];
		unset($candidatearray);
		foreach ($blockable as $candidate) {
			if ($candidate["blockablestars"] <= $winnerstars) {
				$candidatearray[] = $candidate;
			}
		}
		
		if (isset($candidatearray)) {		
			// We got at least one candidate, so block the one with the most stars
			$columns = array_column($candidatearray,'blockablestars');
			array_multisort($columns,SORT_DESC,$candidatearray);
			
			$blockedcontestant = $candidatearray[0]['blockableid'];
		} else {
			// We didn't get any candidates, so sort the main Blockable array
			//     and then block the one with the fewest stars
			
			$columns = array_column($blockable,'blockablestars');
			array_multisort($columns,SORT_ASC,$blockable);
			
			$blockedcontestant = $blockable[0]['blockableid'];
			$strategyverb = "can't punch down, so picks the candidate with the fewest stars";
		}
				
		
		$contestantarray[$blockedcontestant]["blocked"] = 1; 
			
	?>