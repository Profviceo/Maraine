<?php

	if (!isset($_POST['login'])) {
		header("Location: ../login.php?login=submit");
		exit();
	}else{

		include_once 'dbh.inc.php';

		$userinfo = mysqli_real_escape_string($conn,$_POST['userinfo']);
		$password = mysqli_real_escape_string($conn,$_POST['password']);

		if (empty($userinfo) || empty($password)){
			header("Location: ../login.php?login=empty&userinfo=$userinfo");
			exit();
		}elseif(!preg_match("/^[a-zA-Z0-9]*$/", $userinfo) AND !filter_var($userinfo, FILTER_VALIDATE_EMAIL)) {
			header("Location: ../login.php?login=userinfoinvalid&userinfo=$userinfo");
			exit();
		}else{
			//checking database for userinfo
			$sql = "SELECT * FROM users WHERE Email=? || Username=?;";

			$stmt = mysqli_stmt_init($conn);

			//preparing prepared statement
			if (!mysqli_stmt_prepare($stmt,$sql)) {
				header("Location: ../login.php?login=notprepared&userinfo=$userinfo");
				exit();
			}else{
				mysqli_stmt_bind_param($stmt,"ss",$userinfo,$userinfo);
				mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);
				$resultcheck = mysqli_num_rows($result);
				if ($resultcheck >! 0) {
					header("Location: ../login.php?login=notprepared&userinfo=$userinfo");
					exit();
				}else{
					while ($row = mysqli_fetch_assoc($result)) {
						$dbpass = $row['Password'];
						$passwordverify = password_verify($password, $dbpass);
						if ($passwordverify == false) {
							header("Location: ../login.php?login=invalidpass&userinfo=$userinfo");
							exit();
						}else{
							$id = $row['id'];
							$sql = "SELECT * FROM user_profile WHERE user_id = $id ;";
							$result = mysqli_query($conn,$sql);
							$resultcheck = mysqli_num_rows($result);

							if ($resultcheck >! 0) {
								header("Location: ../login.php?login=regnoerror&userinfo=$userinfo");
								exit();
							}else{
								while ($results = mysqli_fetch_assoc($result)) {
								session_start();
								$_SESSION['userid'] = $row['id'];
								$_SESSION['name'] = $row['FullName'];
								$_SESSION['username'] = strtolower($row['Username']);
								$_SESSION['regno']	= $results['Reg_No'];
								$_SESSION['email'] = $row['Email'];
								$_SESSION['dob'] = $row['DOB'];
								$_SESSION['phone'] = $row['Phone'];
								$_SESSION['state'] = $row['State'];
								}
							}
						}

					}
				}
			}
		}

	}

	if ($_SESSION['username'] == "admin") {
		header("Location: ../admin.php");
		exit();
	}
	header("Location: ../index.php?login=success");
