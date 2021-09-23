<?php
	include("../config.php");
	
	// start db connection
	include("../db.php");
	
	// get inputs
	@$id =     $_GET['id'];
	@$secret = $_GET['secret'];
	
	// check if inputs are set
	if (($id !== Null) AND ($secret !== NULL)) {
		// both values are set
		$cursor = $db_conn->prepare("SELECT * FROM scoreboards WHERE id = ? LIMIT 1");
		$cursor->bind_param('s', $id);
		$cursor->execute();
		$res = $cursor->get_result();
		
		if ($res->num_rows == 1) {
			$row = $res->fetch_array(MYSQLI_NUM);
			
			// check if secret and id match
			if (($row[0] == $id) AND ($row[1] == $secret)) {
				// delete all scores from the scoreboard
				$cursor = $db_conn->prepare("DELETE FROM scores WHERE scoreboard = ?");
				$cursor->bind_param('s', $id);
				if ($cursor->execute()) {
					echo "Done!";
				}
			} else {
				// deny access
				$db_conn->close();
				die("No access! Bad id or secret!");
			}
		}
		
	} else {
		echo "No access! Bad id or secret!";
	}
	
	$db_conn->close();
?>