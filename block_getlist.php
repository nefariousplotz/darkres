		<?php
		
		// If alliances are on, build an array containing everybody allied with the winner.
		
		unset ($alliancelistarray);
		if (isset($alliancearray)) {
			foreach($alliancearray as $alliance) {
				if ($alliance['leadid'] == $winnerid) {
					$alliancelistarray[] = $alliance['partnerid'];
				}
			}
		}
		
		// Generate a list of blockable contestants
		//
		// We start at entry 3 (numbered 2, because PHP arrays begin with row 0) because
		// the first two entries in the challenge performances array are the top 2 contestants,
		// who can't be blocked.
		
		$tick = 2;
		unset ($blockable);
		while ($tick < 8) {
			
			$blockableid = $challengeperformances[$tick]["contestantid"];
			$blockablestars = $contestantarray[$blockableid]["starcount"];
			// If an alliance list array exists, alliances are on, and we need to exclude contestants with whom this person is allied.
			if (isset($alliancelistarray) && in_array($blockableid, $alliancelistarray)) {
				// Do not add them as a blockable candidate
			} else {
				// Allow them as a blockable candidate
				$blockable[] = array("blockableid"=>$blockableid, "blockablestars"=>$blockablestars);	
			}
		
			$tick = $tick+1;
		}
		
		?>