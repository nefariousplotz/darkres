	<?php
		if (isset($winnerid)) {
			$lastwinner = $winnerid;
		}
		// First, figure out who's lip syncing
		unset ($winners);
		$winners[] = $challengeperformances[0]["contestantid"];
		$winners[] = $challengeperformances[1]["contestantid"];
		
		// Award stars and satisfy hunger
		$wasblocked = -1;
		foreach($winners as $winner) {
			
				if ($contestantarray[$winner]['blocked'] != 1) {
					$contestantarray[$winner]['starcount'] = $contestantarray[$winner]['starcount']+1;
					$contestantarray[$winner]['hunger'] = 0;
				} else {
					$wasblocked = $winner;
				}
				$contestantarray[$winner]['wincount'] = $contestantarray[$winner]['wincount']+1;

		}
		
		// Do the lip sync
		unset($lipsync);
		foreach($winners as $winner) {
				// Load in scores
				$query = "SELECT score FROM stats WHERE contestantid = ". $winner ." AND challengeid = 5;";
				$result = mysqli_query($mysqli, $query);
				
				// Obtain the base score for this challenge
				while ($row = mysqli_fetch_assoc($result)) {
					$basescore = $row['score'];
				}
				
				$lipsync[] = array("contestantid"=>$winner, "lipsyncscore"=>rand(1,$basescore*100));
		}
		
		// Sort the array
		$columns = array_column($lipsync,'lipsyncscore');
		array_multisort($columns, SORT_DESC, $lipsync);	

		// Award the cash prize
		$winnerid = $lipsync[0]["contestantid"];
		
		$contestantarray[$winnerid]["cash"] = $contestantarray[$winnerid]["cash"]+10000;
		
		if ($shownarrative > 0) {
			if ($shownarrative == 2) { echo "</ul>"; } else {echo "<br />";}
			
			$slug1 = $contestantarray[$winners[0]]["emoji"] ."<strong>". $contestantarray[$winners[0]]["name"] ."</strong>";
				if ($winners[0] == $wasblocked) {
					$slug1 = "<span class='blackstar'>🌟</span>" . $slug1;
				} else {
					$slug1 = "🌟" . $slug1;
				}	
			$slug2 = $contestantarray[$winners[1]]["emoji"] ."<strong>". $contestantarray[$winners[1]]["name"] ."</strong>";
				if ($winners[1] == $wasblocked) {
					$slug2 = "<span class='blackstar'>🌟</span>" . $slug2;
				} else {
					$slug2 = "🌟" . $slug2;
				}	
			echo "[💃]". $slug1 ." and ". $slug2 ." lip sync for their legacy.";
		}
		
		
		
	?>