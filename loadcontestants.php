		<?php
		
		// Load in contestants
		$query = "SELECT * FROM contestants";
		$result = mysqli_query($mysqli, $query);
		
		$smartcontestant = rand(3,10);
		
		unset($contestantarray);
		
		if ($shownarrative == 2) echo "<h3>Pre-Season</h3>";
		
		while ($row = mysqli_fetch_assoc($result)) {
			$row['starcount'] = 0;
			$row['wincount'] = 0;
			$row['cash'] = 0;
			$row['blocked'] = 0;
			$row['hunger'] = 1;
			$row['finalplacement'] = 0;
			$row['through'] = 0;
			if ($alliances == 1) {
				$row['alliance'] = 0;
			}
			
			if ($assignstrategy == -1) {
				$row['strategy'] = array_rand($strategyarray,1);
				if ($shownarrative > 0) echo "<li>[🔮]". $row['emoji'] ."<strong>". $row['name'] ."</strong> has chosen her strategy: ". $strategyarray[$row['strategy']]["name"] .".</li>";
			} else if ($assignstrategy < 100) {
				$row['strategy'] = $assignstrategy;
				if ($shownarrative > 0) echo "<li>[🔮]". $row['emoji'] ."<strong>". $row['name'] ."</strong> has chosen her strategy: ". $strategyarray[$row['strategy']]["name"] .".</li>";
			} else if ($assignstrategy == 100) {
				if ($smartcontestant == $row['id']) {
					$row['strategy'] = rand(3,5);
				if ($shownarrative > 0) 	echo "<li>[🔮]". $row['emoji'] ."<strong>". $row['name'] ."</strong> is the 🎓smart contestant, and chooses her strategy: ". $strategyarray[$row['strategy']]["name"] .".</li>";
				} else {
					$row['strategy'] = rand(0,2);
				if ($shownarrative > 0) 	echo "<li>[🔮]". $row['emoji'] ."<strong>". $row['name'] ."</strong> chooses a basic strategy: ". $strategyarray[$row['strategy']]["name"] .".</li>";
				}
					
			}
			$row['blockslanded'] = 0;
			$contestantarray[$row['id']] = $row;
		}
		
		if ($alliances == 1) {
			unset($alliancearray);
			
			foreach ($contestantarray as $contestant) {
				// Only create an alliance if a contestant does not have an alliance AND they roll an 8.
				if (($contestant['alliance'] == 0) && (rand(1,8) == 8)) {
					
					// Prepare an array of potential partners
					
					unset($partnerarray);
					
					foreach ($contestantarray as $partner) {
							if (($partner['alliance'] == 0) && ($partner['id'] != $contestant['id'])) {
									$partnerarray[] = $partner;
							}
					}
					
					if (isset($partnerarray) != 0) {
					
						$partnerid = $partnerarray[array_rand($partnerarray)]['id'];
						
						// For simplicity's sake, we're inputting this partnership into the array twice. (Once per partner.)
						
						$alliancearray[] = array("leadid"=>$contestant['id'], "partnerid"=>$partnerid);
						$alliancearray[] = array("leadid"=>$partnerid, "partnerid"=>$contestant['id']);
						
						$contestantarray[$contestant['id']]["alliance"] = 1;
						$contestantarray[$partnerid]["alliance"] = 1;
						
						if ($shownarrative > 0) {
							echo "<li>[🤝]". $contestantarray[$contestant['id']]["emoji"] ."<strong>". $contestantarray[$contestant['id']]["name"] ."</strong> forms an alliance with ". $contestantarray[$partnerid]["emoji"] ."<strong>". $contestantarray[$partnerid]["name"] ."</strong></li>";
							
						}
						
					}
				}
			}
			echo "</ul>";
		}

		
		?>