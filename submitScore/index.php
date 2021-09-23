<?php
	include("../config.php");
	
	// start db connection
	include("../db.php");
	
	// get inputs
	@$id =    $_GET['id'];
	@$name =  $_GET['name'];
	@$score = $_GET['score'];
	
	// check if inputs are set AND checks the name with regex
	if (($id !== Null) AND ($name !== Null) AND ($score !== NULL)) {
		// check to see if the scoreboard exists
		$cursor = $db_conn->prepare("SELECT * FROM scoreboards WHERE id = ? LIMIT 1");
		$cursor->bind_param('s', $id);
		$cursor->execute();
		$res = $cursor->get_result();
		
		if ($res->num_rows == 1) {
			// will be run if the scoreboard exists
			$cursor = $db_conn->prepare("INSERT INTO scores (scoreboard, name, score) VALUES (?, ?, ?)");
			$cursor->bind_param('sss', $id, $name, $score);
			if ($cursor->execute()) {
				echo "Done!";
			}
		}
	} else {
		echo "Bad request!";
	}
	
	$db_conn->close();
?>