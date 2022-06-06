	<?php
	
		// Figure out who's blockable and unblock everybody
		
		include "block_getlist.php";
		include "unblock.php";
	
		// Create a string containing every implicated challenge ID so we can put it
		// into SQL in a bit
		$queryinclude = "";
		foreach ($challengearray as $challenge) {
			if ($challenge['done'] == 1) {
				$queryinclude = $queryinclude . ", " . $challenge['id'];
			}
		}
		$queryinclude = substr($queryinclude, 2);	
		
		// We're cracking up, so we need to know how many stars the winner has.
		$winnerstars = $contestantarray[$winnerid]["starcount"];
		
		// Sort the blockable array so that the person with the most stars comes first.
		// This will break ties in favour of blocking the person with the most stars.
		$columns = array_column($blockable,'blockablestars');
		array_multisort($columns,SORT_DESC,$blockable);
		
		// Cycle through each candidate, check whether they're eligible for blocking
		// (we're cracking up!), and if they are, pull their scores from the DB, then
		// tally them up and add them to the candidatearray.
		unset ($candidatearray);
		foreach ($blockable as $candidate) {
			$candidateid = $candidate["blockableid"];
			if ($contestantarray[$candidateid]['starcount'] >= $winnerstars) {				
				$runningscore = 0;
				$query = "SELECT score FROM stats WHERE contestantid = ". $candidate["blockableid"] ." AND challengeid NOT IN (". $queryinclude .");";
				$result = mysqli_query($mysqli, $query);							
				while ($row = mysqli_fetch_assoc($result)) {
					$runningscore = $row['score']+$runningscore;
				}
				$candidatearray[] = array("candidateid"=>$candidate['blockableid'], "score"=>$runningscore);
			}
		}
		


		
		// Did we get at least one candidate? (If the candidatearray has at least one line, we did!)
		
		if (isset($candidatearray)) {
			// We did! Sort the table, then block whoever has the highest potential score
		
			$columns = array_column($candidatearray,'score');
			array_multisort($columns,SORT_DESC,$candidatearray);
			
			// Block whoever's on top
			
			$blockedcontestant = $candidatearray[0]["candidateid"];
			
		} else {
			// We didn't get at least one candidate, so we're going to crack the code instead.
			$strategyverb = "can't crack up, so cracks the code instead";
			include "block_crackthecode.php";
		}
				
		// Block 'em. */
				
		if ($blockedcontestant != -1) {
			$contestantarray[$blockedcontestant]["blocked"] = 1; 
		}
			
	?>