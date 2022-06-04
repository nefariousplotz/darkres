		<?php
		$query = "SELECT id, nameshort, namelong FROM challenges WHERE placement = 2 ORDER BY RAND() LIMIT ". ($maxchallenge - 3);
		$result = mysqli_query($mysqli, $query);
		
		unset ($challengearray);
		unset ($randomchallengearray);
		
		// Add Snatch Game to the random list
		$randomchallengearray[] = array("id"=>3, "done"=>0, "nameshort"=>"snatch", "namelong"=>"Snatch Game");
		
		// Draw 7 challenges for the random list
		while ($row = mysqli_fetch_assoc($result)) {
			$row['done'] = 0;
			$randomchallengearray[] = $row;
		}
		
		// Shuffle the random list
		shuffle($randomchallengearray);
		
		$challengearray[] = array("id"=>13, "done"=>0, "nameshort"=>"talentshow", "namelong"=>"Talent Show");
		foreach ($randomchallengearray as $randomchallenge) {
			$challengearray[] = $randomchallenge;
		}
		$challengearray[] = array("id"=>12, "done"=>0, "nameshort"=>"rumix", "namelong"=>"Rumix");
		?>