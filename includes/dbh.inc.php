<?php

	$Host = "localhost";
	$Username = "root";
	$password = "";
	$DbName = "maraine";


	$conn = mysqli_connect($Host,$Username,$password,$DbName);


	if (!$conn) {
		die("Connection Failed".Mysqli_connect_error());
	}
