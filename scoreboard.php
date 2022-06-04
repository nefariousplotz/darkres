<?php

				echo "<br /><br />";
				echo "<table style='border:1px solid black;'>";
				
				// First row has the challenge names
				echo "<tr>";
				echo "<td class='headerrow'>Icon</td>";
				echo "<td class='headerrow' style='width:200px'>Contestant</td>";
				foreach ($challengearray as $challenge) {
				
					echo "<td class='headerrow'>";
						echo $challenge['namelong'];
					echo "</td>";
				}
				echo "<td class='headerrow' style='width:200px'>Outcome</td>";
				echo "</tr>";
				
				// Every subsequent row is about a contestant
				foreach ($contestantarray as $contestant) {
					$contestantid = $contestant["id"];

					echo "<tr>";
					echo "<td class='contestantemoji'>";
						echo $contestant['emoji'];
					echo "</td>";
					echo "<td>";
						echo "<span class='contestantname'>";
						echo $contestant['name'];
						echo "</span><br />";
						echo "<span class='contestanttitle'>";
						echo $contestant['title'];
						echo "</span>";
					echo "</td>";
					foreach ($challengearray as $challenge) {
						$challengeid = $challenge["id"];

						unset($findchallengerow);
						$findchallengerow = array_filter($scoreboard, fn($data) => $data['contestantid'] == $contestant["id"] && $data['challengeid'] == $challenge["id"] );
						
						$challengerow = key($findchallengerow);
						
						$bling = $scoreboard[$challengerow]["bling"];
						$blockednext = $scoreboard[$challengerow]["blockednext"];
						$wonlipsync = $scoreboard[$challengerow]["wonlipsync"];
						
						echo "<td class='challengeresult'>";
							if ($bling == 1) {
									echo "🌟";
							} else if ($bling == -1) {
									echo "<span class='blackstar'>🌟</span>";
							}
							if ($wonlipsync == 1) {
									echo "💰";
							}
							if ($blockednext == 1) {
									echo "🪠";
							}
						echo "</td>";
						
						
					}
					echo "<td class='outcomebox'>";
						$starcount = $contestant['starcount'];
						$wincount = $contestant['wincount'];
						$blackstars = $wincount - $starcount;
						$cash = $contestant['cash'];
						$blockslanded = $contestant['blockslanded'];
						
						while ($starcount > 0) {
							echo "🌟";
							$starcount = $starcount - 1;
						}
						
						if ($blackstars > 0) {
							echo "<span class='blackstar'>";
							while ($blackstars > 0) {
								echo "🌟";
								$blackstars = $blackstars - 1;
							}
							echo "</span>";
						}
						
						while ($blockslanded > 0) {
							echo "🪠";
							$blockslanded = $blockslanded - 1;
						}
						
						echo "<br />Placement: ";
						echo $contestant['placement'];
						if ($cash > 0) {
								echo " / $". $cash;
						}
					echo "</td>";
				}
				
				
				echo "</table>"; 
			
			
?>