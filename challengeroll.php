	<?php // Load in a challenge
		unset($challengeperformances);
		$currentcontestant = array_search(min($contestantarray), $contestantarray);
		
		if ($shownarrative > 0) {
				echo "<div class='challengebox'>";
				echo "<h3>Episode ". intval($currentchallenge+1) ."</h3>";
				echo "[🏁]Racers, start your engines! This week's maxi challenge is <strong>". $challengearray[$currentchallenge]['namelong'] ."</strong>!";
				if ($shownarrative == 2) echo "<ul>";
		}
			// Roll for performances
			while ($currentcontestant <= $maxcontestant) {
				
				// Load in scores
				$query = "SELECT score FROM stats WHERE contestantid = ". $currentcontestant ." AND challengeid = ". $challengearray[$currentchallenge]['id'] .";";
				$result = mysqli_query($mysqli, $query);
				
				// Obtain the base score for this challenge
				while ($row = mysqli_fetch_assoc($result)) {
					$basescore = $row['score'];

				}
				
				// If the contestant is hungry, give them a bonus
				if ($contestantarray[$currentcontestant]['hunger'] == 1) {
					$basescore = $basescore+2;
					if ($shownarrative == 2) {
						echo "<li>[🎲]". $contestantarray[$currentcontestant]["emoji"] ."<strong>". $contestantarray[$currentcontestant]["name"] ."</strong> (<strong>". $basescore."/10</strong>🔥)";
					}
				} else if ($shownarrative == 2) {
						echo "<li>[🎲]". $contestantarray[$currentcontestant]["emoji"] ."<strong>". $contestantarray[$currentcontestant]["name"] ."</strong> (<strong>". $basescore."/10</strong>)";
				}	
				
				// Load the result into the performance array
				
				$contestantscore = rand(1,$basescore*100);
				
				if ($shownarrative == 2) echo " rolls <strong>". $contestantscore ."</strong> out of a maximum of ". $basescore*100 .". </li>";
				
				$challengeperformances[] = array("contestantid"=>$contestantarray[$currentcontestant]["id"], "contestantscore"=>$contestantscore);
				$currentcontestant = $currentcontestant+1;
				
			}
			
		if ($shownarrative == 2) {
			echo "</ul>";
		}
	
		$columns = array_column($challengeperformances,'contestantscore');
		array_multisort($columns, SORT_DESC, $challengeperformances);
		
		$challengearray[$currentchallenge]["done"] = 1;
		
		
		
	?>