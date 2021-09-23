<?php
	include("../config.php");
	
	// start db connection
	include("../db.php");
	
	// get inputs
	@$id = $_GET['id'];
	
	// check if inputs is not null
	if ($id !== NULL) {
		// check to see if the scoreboard exists
		$cursor = $db_conn->prepare("SELECT * FROM scoreboards WHERE id = ? LIMIT 1");
		$cursor->bind_param('s', $id);
		$cursor->execute();
		$res = $cursor->get_result();
		
		if ($res->num_rows == 1) {
			$cursor = $db_conn->prepare("SELECT * FROM scores WHERE scoreboard = ? ORDER BY score DESC LIMIT 5");
			$cursor->bind_param('s', $id);
			$cursor->execute();
			$res = $cursor->get_result();
			
			// array to be converted to json and sent to user
			$score_board = [];
			
			if ($res->num_rows > 0) {
				$i = 1;
				while($row = $res->fetch_array(MYSQLI_NUM)) {
					$name  = $row[2];
					$score = $row[3];
					
					// create array for each row
					$local = [];
					$local["name"]  = $name;
					$local["score"] = $score;
					
					// push local array into score_board array
					$score_board[$i] = $local;
					
					$i++;
				}
				
				// convert array to json, and send to user
				echo json_encode($score_board);
			}
			
		} else {
			echo "Bad request!";
		}
		
	} else {
		echo "Bad request!";
	}
	
	$db_conn->close();

?>
	
	