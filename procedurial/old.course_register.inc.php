<?php


	if (!isset($_POST['submit'])) {
		header("Location: ../course_register.php?register=submit");
		exit();
	}else{

		require_once 'dbh.inc.php';
		session_start();
		$userid = $_SESSION['userid'];
		$useremail = $_SESSION['email'];
		$empty = "emmpty";
		$courses = array("business studies","project management","business administration","transport management");

		$course_1 = strtolower(mysqli_real_escape_string($conn,$_POST['course_1']));
		$course_2 = strtolower(mysqli_real_escape_string($conn,$_POST['course_2']));
		$course_3 = strtolower(mysqli_real_escape_string($conn,$_POST['course_3']));
		$course_4 = strtolower(mysqli_real_escape_string($conn,$_POST['course_4']));

		$DbCourses = $course_1.",".$course_2.",".$course_3.",".$course_4;

		if (empty($course_1) || empty($course_2) || empty($course_3) || empty($course_4)) {
			header("Location: ../course_register.php?register=empty");
			exit();
		}elseif (!preg_match("/^[a-zA-Z ]*$/", $course_1) || !preg_match("/^[a-zA-Z ]*$/", $course_2) || !preg_match("/^[a-zA-Z ]*$/", $course_3) || !preg_match("/^[a-zA-Z ]*$/", $course_4)) {
			header("Location: ../course_register.php?register=invalidchar");
			exit();
		}elseif (!in_array($course_1, $courses)) {
			header("Location: ../course_register.php?register=invalidcourse1");
			exit();
		}elseif (!in_array($course_2, $courses)) {
			header("Location: ../course_register.php?register=invalidcourse2");
			exit();
		}elseif (!in_array($course_3, $courses)) {
			header("Location: ../course_register.php?register=invalidcourse3");
			exit();
		}elseif (!in_array($course_4, $courses)) {
			header("Location: ../course_register.php?register=invalidcourse4");
			exit();
		}else{
			
			$sql = "SELECT * FROM courses WHERE userid = ?;";
			$stmt = mysqli_stmt_init($conn);

			if (!mysqli_stmt_prepare($stmt,$sql)) {
				header("Location: ../course_register.php?register=notprepared1");
			exit();
			}else{
				mysqli_stmt_bind_param($stmt,"s",$userid);
				mysqli_stmt_execute($stmt);

				$result = mysqli_stmt_get_result($stmt);
				$resultcheck = mysqli_num_rows($result);
				if ($resultcheck > 0) {
					header("Location: ../course_register.php?register=donebefore");
					exit();
				}else{

				$sql = "INSERT INTO courses(userid,useremail,courses,emtpy) VALUES(?,?,?,?);";

				$stmt = mysqli_stmt_init($conn);

				if (!mysqli_stmt_prepare($stmt,$sql)) {
					header("Location: ../course_register.php?register=notprepared2");
					exit();
				}else{

					mysqli_stmt_bind_param($stmt,"ssss",$userid,$useremail,$DbCourses,$empty);
					mysqli_stmt_execute($stmt);
				}
			}
		}
	}
		


	}



	header("Location: ../course_register.php?register=success");
					