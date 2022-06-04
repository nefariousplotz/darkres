<html>
  <head>
    <link rel="stylesheet" href="style.css">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Drag Race All Stars Simulator</title>
  </head>
  <body>
	<h1>Racers, Start Your Engines!</h1>

	<?php
		// Connect to the database
		$mysqli = new mysqli("[host]", "[username]", "[password]", "[database]");
		
		
		// Configure this session
		//
		//
		
		// How many seasons are we running?
		$cycles = 5;

		// Are we recording our results in the database?
		$record = 1;
		
		// Do you want to see a scoreboard?
		// 0 for no scoreboard
		// 1 for a scoreboard for just the first season (to confirm it's working properly)
		// 2 for a scoreboard for every season
		$showscoreboard = 2;
		
		// Do you want a narrative?
		// 0 for no narrative
		// 1 for a limited narrative (setup, challenge winners, results only)
		// 2 for a full narrative (every roll)
		$shownarrative = 2;
		
		// Are we doing alliances?
		$alliances = 1;
		
		// How many challenges per season?
		$maxchallenge = 12;
		
		// Which strategy are we using?
		// -1 to assign each contestant a strategy at random
		// 0 to force everyone to use random selection
		// 1 to force everyone to punch up
		// 2 to force everyone to punch down
		// 3 to force everyone to crack the code
		// 4 to force everyone to crack down
		// 5 to force everyone to crack up
		// 100 to have one contestant select a "smart" strategy at random (2, 3, 4, 5)
		//				and everyone else select a "dumb" strategy at random (0, 1)
		$assignstrategy = -1;
		
		//
		//
		//
		// 
		// All right... let's go!
		
		if ($record == 1) {
			// We're recording into the database, so we're going to flush the DB to receive the new records.
			mysqli_query($mysqli, "delete from results");
		}
		
		$currentcycle = 0;
		
		while ($currentcycle < $cycles) {
			
			if ($shownarrative > 0 OR $showscoreboard == 2) {
				echo "<h2>nefariousplotz' Dark Ras Ill Stir: Season ". intval($currentcycle + 1) ."</h2>";
				echo "<ul>";
			}
			
			// Start Up
			include "loadchallenges.php";
			include "loadstrategies.php";
			include "loadcontestants.php";
			unset ($placementarray);
			unset ($scoreboard);
			
			set_time_limit(30);

			// Count stuff, plan floors and ceilings
			$currentchallenge = 0;
			$currentcontestant = array_search(min($contestantarray), $contestantarray);
			$maxcontestant = array_search(max($contestantarray), $contestantarray);
			$blockedcontestant = -1;
			
			while ($currentchallenge < $maxchallenge) {
				
				// Roll the challenge, then roll the lip sync
				include ("challengeroll.php");
				include ("lipsync.php");
				
				if (isset($blockedcontestant)) {
						$wasblocked = $blockedcontestant;
				}
				
				unset ($strategynumber, $strategyfile, $strategyverb);
				
				if ($currentchallenge != ($maxchallenge - 1)) {
					// Figure out how the winner blocks
					$strategynumber = $contestantarray[$winnerid]["strategy"];
					$strategyfile = $strategyarray[$strategynumber]["file"];
					$strategyverb = $strategyarray[$strategynumber]["verb"];
					include $strategyfile;
				} else {
					// If it's the final challenge, nobody blocks
					$blockedcontestant = -1;
				}
				
				// Because blocking strategy is hived off into separate files and I feel lazy, we're going to summarize the lip sync here.
				
				if ($shownarrative > 0 && $blockedcontestant != -1) {
					echo "<br />[🪠]". $contestantarray[$winnerid]["emoji"] ."<strong>". $contestantarray[$winnerid]["name"] ."</strong> (". $contestantarray[$winnerid]["starcount"] ."&nbsp;🌟) wins the lip sync, ". $strategyverb .", and blocks ". $contestantarray[$blockedcontestant]["emoji"] ."<strong>". $contestantarray[$blockedcontestant]["name"] ."</strong>. (". $contestantarray[$blockedcontestant]["starcount"] ."&nbsp;🌟)</div>";
				} else if ($shownarrative > 0) {
					echo "<br />[💰]". $contestantarray[$winnerid]["emoji"] ."<strong>". $contestantarray[$winnerid]["name"] ."</strong> (". $contestantarray[$winnerid]["starcount"] ."&nbsp;🌟) wins the lip sync but doesn't get to block anybody, as it's the last challenge.</div>";
				}
				
				
				// The challenge performance array is always pre-sorted from highest score to lowest, so the first placement is 1
				$challengeplacement = 1;
				
				foreach ($challengeperformances as $performance) {
						$wonlipsync = 0;
						$performancecontestant = $performance['contestantid'];
						if ($challengeplacement < 3) {
							if ($performancecontestant == $wasblocked) {
								// Contestant is blocked, so they get a win but no star.
								$bling = -1;
								// Someone blocked a star! Add it to the blocker's total.
								$contestantarray[$lastwinner]["blockslanded"] = $contestantarray[$lastwinner]["blockslanded"] + 1;
							} else {
								// Contestant was not blocked, so they get a win and a star.
								$bling = 1;		
							}
									
							if ($winnerid == $performancecontestant) {
									$wonlipsync = 1;
							}
						} else {
							// Contestant finished in third place or worse, so no win and no star.
							$bling = 0;
						}
												
						// In order to show the plunger on the scoreboard, we need to know who'll be blocked in the next round, without altering information about who was blocked this round.
						if ($blockedcontestant == $performancecontestant) {
								$blockednext = 1;
						} else {
								$blockednext = 0;
						}
						$scoreboard[] = array("contestantid"=>$performancecontestant, "challengeid"=>$challengearray[$currentchallenge]['id'], "placement"=>$challengeplacement, "bling"=>$bling, "blockednext"=>$blockednext, "wonlipsync"=>$wonlipsync);
						$challengeplacement = $challengeplacement+1;
				}
				
				$currentchallenge = $currentchallenge+1;
			}
			
			
			// Figure out final placements
			
				// Create an array we can safely mess with
				
				unset ($placementarray);
				
				foreach ($contestantarray as $contestant) {
					$finalscore = 0;
					
					// Stars are worth 10000 points, wins are worth 100 points, and lip sync wins are worth 1 point
					$finalscore = $finalscore + ($contestant['starcount']*10000);
					$finalscore = $finalscore + (($contestant['wincount']-$contestant['starcount'])*100);
					$finalscore = $finalscore + ($contestant['cash']/10000);
					
					$placementarray[] = array("contestantid"=>$contestant['id'],"finalscore"=>$finalscore);
					
				}
				
				// Shuffle the array to break ties once we sort it
				shuffle($placementarray);
				$columns = array_column($placementarray,'finalscore');
				array_multisort($columns, SORT_DESC, $placementarray);
				
				
				// Send placements to the contestant array
				$finalplacement = 1;
				foreach ($placementarray as $placement) {
						$contestantid = $placement["contestantid"];
						$contestantarray[$contestantid]['placement'] = $finalplacement;
						++$finalplacement;
				}
				
			
			if ($shownarrative > 0) {
					echo "</ul>";
			}
			
			// Are we posting a scoreboard?
			
			if ($showscoreboard == 2 OR ($showscoreboard == 1 && $currentcycle == 1)) {
				// If we are showing a scoreboard, pre- sort the contestant array by placement.
				
				$columns = array_column($contestantarray,'placement');
				array_multisort($columns, SORT_ASC, $contestantarray);	
				
				include ("scoreboard.php");
				
				if ($shownarrative > 0) {
					echo "<br /><hr />";
				}
			}

			// If we're recording to the DB, record the result.
			if ($record == 1) {
				
				$values = "";
			
				foreach ($contestantarray as $contestant) {
					$round = $currentcycle;
					$contestantid = $contestant["id"];
					$wincount = $contestant["wincount"];
					$starcount = $contestant["starcount"];
					$placement = $contestant["placement"];
					$strategy = $contestant["strategy"];
					$blockslanded = $contestant["blockslanded"];
					if ($alliances == 1) {
						$alliance = $contestant["alliance"];
					} else {
						$alliance = 0;
					}
					$values = $values ."(". $round .", ". $contestantid .", ". $wincount .", ". $starcount .", ". $placement .", ". $strategy .", ". $blockslanded .", ". $alliance ."), ";
				}
				
				$fullquery = "INSERT INTO results (round, contestantid, wincount, starcount, placement, strategy, blockslanded, alliance) VALUES ". $values;
				
				$lenfullquery = strlen($fullquery);
				
				$fullquery = substr($fullquery,0,$lenfullquery-2);
				
				mysqli_query($mysqli, $fullquery);
			
			}
			
			// Increment the number of cycles
			$currentcycle = $currentcycle+1;
		} 
		
			


	?>

  </body>
</html>
