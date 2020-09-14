<?php

	session_start();
	require_once "Autoloader.inc.php";
	

	$Fullname =  $_POST['Fullname'];
	$Username =  $_POST['Username'];
	$useremail = $_POST['useremail'];
	$password =  $_POST['password'];
	$confirm =  $_POST['confirm'];
	$Phone =  $_POST['Phone'];
	$dob =  $_POST['dob'];
	$state = strtolower($_POST['StateOrigin']);
	$StateOrigin =  $state;	

	$Validator = new Validator();
	$Validator->SignupValues($Fullname, $Username, $useremail, $password, $confirm, $Phone, $dob, $state);
	$Validate = $Validator->Signupvalidate();


	$Signup = new Usercontr;
	$Signup->SignupValuesConfirmed($Fullname, $Username, $useremail, $password, $confirm, $Phone, $dob, $state);
	$Signup->Signup($Validate);