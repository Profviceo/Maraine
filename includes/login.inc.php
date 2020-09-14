<?php

	session_start();
	require_once "Autoloader.inc.php";


	$userinfo = $_POST['userinfo'];
	$Password = $_POST['password'];


	$Validator = new Validator();
	$validate = $Validator->LoginValidator($userinfo,$Password);

	$Userview = new Userview();
	$Userview->LoginBot($validate, $userinfo);