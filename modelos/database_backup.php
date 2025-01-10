<?php

    error_reporting(0);

	include 'backup_function.php';
	include '../config/APP.php';
		
		$server = "localhost";
		$username = "root";
		$password = "";
		$dbname = "sto";

		
		backDb($server, $username, $password, $dbname);

		exit();

?>