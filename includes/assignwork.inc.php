<?php

	session_start();
	require_once 'Autoloader.inc.php';

	$course = strtolower($_POST['course']);
	$lecturer = $_POST['Lecturer_Name'];
	$submission = $_POST['submission'];
	$title = $_POST['assign_title'];
	$filename = $_POST['filename'];
	$fileRealName = $filename.".".mt_rand();
	$file = $_FILES['file'];
	$fileDataName = $_FILES['file']['name'];
	$fileTmp = $_FILES['file']['tmp_name'];
	$filesize = $_FILES['file']['size'];
	$fileError = $_FILES['file']['error'];
	$fileExt = explode(".", $fileDataName);
	$fileRealExt = strtolower($fileExt[1]);
	$filedestination = "../uploads/".$fileRealName.".".$fileRealExt;

	$Validator = new Validator();
	$validate = $Validator->AssignWorkValidator($course, $lecturer, $submission, $title, $filename, $fileDataName, $filesize);

	$ASWH = new Usercontr();
	$ASWH->AssignWork($validate, $course, $lecturer, $submission , $title, $fileRealName,  $fileTmp, $filedestination);