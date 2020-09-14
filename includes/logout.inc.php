<?php

	// require_once 'google.config.inc.php';
	// if ($_GET['logout'] !== "valid") {
	// 	header("Location: ../index.php?logout");
	// 	exit();
	// }else{
		session_start();
		session_unset();
		session_destroy();	
		// $gClient->revokeToken();
	
	header("Location: ../login.php?logout=success");