<?php 
	// connecting to database
	$db_conn = new mysqli($db_server, $db_user, $db_pass, $db_name);
	
	// check connection
	if ($conn->connect_error) {
		die("Cannot access database!");
	} else {
		// everything is okay
	}
	
	// check if tables exists
	$c = 0;
	if ($db_conn->query("SELECT * FROM `scoreboards` LIMIT 1") !== False) {
		$c++;
	}
	
	if ($db_conn->query("SELECT * FROM `scores` LIMIT 1") !== False) {
		$c++;
	}
	
	if ($c == 2) {
		// everything is good
	} else {
		if ($c == 0) {
			// setting up tables
			$db_conn->query("CREATE TABLE `scoreboard`.`scoreboards` ( `id` VARCHAR(255) NOT NULL , `secret` VARCHAR(255) NOT NULL ) ENGINE = InnoDB;");
			$db_conn->query("CREATE TABLE `scoreboard`.`scores` ( `id` INT(255) NOT NULL AUTO_INCREMENT , `scoreboard` VARCHAR(255) NOT NULL , `name` VARCHAR(255) NOT NULL , `score` INT(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
			die("error with database, please try again!");
			$db_conn->close();
		}
		die("critical error, database corrupted!");
		$db_conn->close();
	}
	
?>