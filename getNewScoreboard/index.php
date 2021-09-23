<?php
	include("../config.php");
	
	// start db connection
	include("../db.php");
	
	// generate random id and secret
	$random_id = sha1(rand(0000, 9999) . rand(0000, 9999) . rand(0000, 9999) . rand(0000, 9999) . rand(0000, 9999));
	$random_secret = sha1(rand(0000, 9999) . rand(0000, 9999) . rand(0000, 9999) . rand(0000, 9999) . rand(0000, 9999));
	
	// check if id is free
	$cursor = $db_conn->prepare("SELECT id FROM scoreboards WHERE id = ?");
	$cursor->bind_param('s', $random_id);
	$cursor->execute();
	$res = $cursor->get_result();
	
	if ($res->num_rows == 0) {
		// its free lets get going...
		// lets insert the new scoreboard
		$cursor = $db_conn->prepare("INSERT INTO scoreboards (id, secret) VALUES (?, ?)");
		$cursor->bind_param('ss', $random_id, $random_secret);
		$cursor->execute();
		
		
		// tell the user
		echo "New&nbsp;scoreboard&nbsp;has&nbsp;been&nbsp;created!<br />";
		echo "You'r&nbsp;credentials&nbsp;are:<br />";
		echo "ScoreBoard id:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		echo $random_id;
		echo "<br />";
		echo "ScoreBoard&nbsp;secret:&nbsp;";
		echo $random_secret;
		echo "&nbsp;*Keep&nbsp;this&nbsp;a&nbsp;secret*";
		
		//close db
		$db_conn->close();
		
	} else {
		$db_conn->close();
		die("Error!");
	}
	
	
?>