<?php


	if (!isset($_POST['submit'])) {
		header("Location: ../assignwork.php?submit=submit");
		exit();
	}else{
		require_once 'dbh.inc.php';
		session_start();
		$course = strtolower(mysqli_real_escape_string($conn,$_POST['course']));
		$lecturer = mysqli_real_escape_string($conn,$_POST['Lecturer_Name']);
		$submission = mysqli_real_escape_string($conn,$_POST['submission']);
		$title = mysqli_real_escape_string($conn,$_POST['assign_title']);
		$filename = mysqli_real_escape_string($conn,$_POST['filename']);
		$fileRealName = $filename.".".mt_rand();
		$file = $_FILES['file'];
		$fileDataName = $_FILES['file']['name'];
		$fileTmp = $_FILES['file']['tmp_name'];
		$filesize = $_FILES['file']['size'];
		$fileError = $_FILES['file']['error'];
		$fileExt = explode(".", $fileDataName);
		$fileRealExt = strtolower($fileExt[1]);
		$filedestination = "../uploads/".$fileRealName.".".$fileRealExt;

		if (empty($course) || empty($lecturer) || empty($submission) || empty($title) || empty($filename) || empty($fileDataName) ) {
			header("Location: ../assignwork.php?submit=empty");
			exit();
		}elseif (!preg_match("/^[a-zA-Z ]*$/", $lecturer) || !preg_match("/^[a-zA-Z0-9 ]*$/", $filename)) {
			header("Location: ../assignwork.php?submit=invalidchar");
			exit();
		}elseif ($filesize > 50000000) {
			header("Location: ../assignwork.php?submit=filetoobig");
			exit();
		} else{

			$sql = "SELECT * FROM assign_given;";
			$stmt = mysqli_stmt_init($conn);

			if (!mysqli_stmt_prepare($stmt,$sql)) {
				header("Location: ../assignwork.php?submit=notprepared");
				exit();
			}else{
				mysqli_stmt_execute($stmt);
				$sql = "INSERT INTO assign_given(Course,Lecturer,submissiondate,assign_title,Filename) VALUES(?,?,?,?,?);";
				$stmt = mysqli_stmt_init($conn);

				if (!mysqli_stmt_prepare($stmt,$sql)) {
					header("Location: ../assignwork.php?submit=notprepared");
					exit();
				}else{
					mysqli_stmt_bind_param($stmt, "sssss",$course,$lecturer,$submission ,$title,$fileRealName);
					mysqli_stmt_execute($stmt);

					move_uploaded_file($fileTmp, $filedestination);


				}
			}
		}
	}

	header("Location: ../assignwork.php?submit=success");