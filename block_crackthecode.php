	<?php
	
		// Figure out who's blockable
		
		include "block_getlist.php";
		include "unblock.php";
	
		// Create a string containing every implicated challenge ID so we can put it
		// into SQL in a bit
		unset ($codecrackerarray);
		$queryinclude = "";
		foreach ($challengearray as $challenge) {
			if ($challenge['done'] == 1) {
				$queryinclude = $queryinclude . ", " . $challenge['id'];
			}
		}
		$queryinclude = substr($queryinclude, 2);	
		
		// We're cracking up, so we need to know how many stars the winner has.
		$winnerstars = $contestantarray[$winnerid]["starcount"];
		
		// Cycle through each candidate, pull their scores from the DB, then
		// tally them up and add them to the candidatearray.
		unset ($candidatearray);
		foreach ($blockable as $candidate) {
			$candidateid = $candidate["blockableid"];
			$runningscore = 0;
			$query = "SELECT score FROM stats WHERE contestantid = ". $candidate["blockableid"] ." AND challengeid NOT IN (". $queryinclude .");";
			$result = mysqli_query($mysqli, $query);							
			while ($row = mysqli_fetch_assoc($result)) {
				$runningscore = $row['score']+$runningscore;
			}
			$candidatearray[] = array("candidateid"=>$candidate['blockableid'], "score"=>$runningscore);
		}
		
		// Sort the table
		
		$columns = array_column($candidatearray,'score');
		array_multisort($columns,SORT_DESC,$candidatearray);
		
		// Block whoever's on top
		
		$blockedcontestant = $candidatearray[0]["candidateid"];
								
		// Block 'em.
				
		if ($blockedcontestant != -1) {
			$contestantarray[$blockedcontestant]["blocked"] = 1; 
		}
			
	?>