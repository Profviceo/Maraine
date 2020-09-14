<?php


	session_start();
	require_once 'Autoloader.inc.php';


	$course_1 = strtolower($_POST['course_1']);
	$course_2 = strtolower($_POST['course_2']);
	$course_3 = strtolower($_POST['course_3']);
	$course_4 = strtolower($_POST['course_4']);

	$Validator = new Validator();
	$ValidateArray =  ($Validator->CourseRegValidator($course_1, $course_2, $course_3, $course_4));
	$validate = $ValidateArray[0];
	$Dbcourses = $ValidateArray[1];

	$CourseReg =  new Usercontr();
	$CourseReg->CourseRegistrar($validate, $Dbcourses);