<?php

	$Host = "sql207.epizy.com";
	$Username = "epiz_26581842";
	$password = "8agVYgazusq4I";
	$DbName = "epiz_26581842_maraine";


	$conn = mysqli_connect($Host,$Username,$password,$DbName);


	if (!$conn) {
		die("Connection Failed".Mysqli_connect_error());
	}