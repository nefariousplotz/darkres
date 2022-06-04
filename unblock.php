<?php
	foreach ($contestantarray as $unblocking) {
		$id = $unblocking["id"];
		$contestantarray[$id]["blocked"] = 0;
	}
?>