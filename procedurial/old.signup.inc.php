<?php

	if (!isset($_POST['submit'])) {
		header("Location: ../Signup.php?signup=submit");
		exit();
	}else{
		require_once  'dbh.inc.php';

		$Fullname = mysqli_real_escape_string($conn, $_POST['Fullname']);
		$Username = mysqli_real_escape_string($conn, $_POST['Username']);
		$useremail = mysqli_real_escape_string($conn, $_POST['useremail']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);
		$confirm = mysqli_real_escape_string($conn, $_POST['confirm']);
		$Phone = mysqli_real_escape_string($conn, $_POST['Phone']);
		$dob = mysqli_real_escape_string($conn, $_POST['dob']);
		$state = strtolower(mysqli_real_escape_string($conn,$_POST['StateOrigin']));
		$StateOrigin = str_replace(" ", "", $state);
		$states = array("abia","abuja","adamawa","akwa ibom" ,"anambra","bauchi","bayelsa","benue","borno","cross river","delta","ebonyi","edo","ekiti","enugu","gombe","imo","jigawa","kaduna","kano","katsina","kebbi","kogi","kwara","lagos","nasarawa","niger","ogun","ondo","osun","oyo","plateau","rivers","sokoto","taraba","yobe","zamfara");

		if (empty($Fullname) || empty($Username) || empty($useremail) || empty($password)  || empty($confirm) || empty($Phone) || empty($dob) || empty($StateOrigin))
		 {
				header("Location: ../Signup.php?signup=empty&Fullname=$Fullname&Username=$Username&useremail=$useremail&Phone=$Phone&StateOrigin=$StateOrigin");
				exit();
		}elseif (!preg_match("/^[ a-zA-Z]*$/", $Fullname)) {
			header("Location: ../Signup.php?signup=nameerror&Fullname=$Fullname&Username=$Username&useremail=$useremail&Phone=$Phone&StateOrigin=$StateOrigin");
			exit();
		}elseif (!preg_match("/^[a-zA-Z0-9]*$/", $Username)){
			header("Location: ../Signup.php?signup=usernameinvalid&Fullname=$Fullname&Username=$Username&useremail=$useremail&Phone=$Phone&StateOrigin=$StateOrigin");
			exit();
		}elseif (!preg_match("/^[0-9]*$/", $Phone)) {
			header("Location: ../Signup.php?signup=invalidphone&Fullname=$Fullname&Username=$Username&useremail=$useremail&Phone=$Phone&StateOrigin=$StateOrigin");
			exit();
		}elseif (!filter_var($useremail, FILTER_VALIDATE_EMAIL)) {
			header("Location: ../Signup.php?signup=invalidemail&Fullname=$Fullname&Username=$Username&useremail=$useremail&Phone=$Phone&StateOrigin=$StateOrigin");
			exit();
		}elseif (strlen($password) < 8 || strlen($password) > 21) {
			header("Location: ../Signup.php?signup=lesspass&Fullname=$Fullname&Username=$Username&useremail=$useremail&Phone=$Phone&StateOrigin=$StateOrigin");
			exit();
		}elseif (!preg_match('/[^a-zA-Z0-9]/', $password)) {
			header("Location: ../Signup.php?signup=passnochar&Fullname=$Fullname&Username=$Username&useremail=$useremail&Phone=$Phone&StateOrigin=$StateOrigin");
			exit();
		}elseif ($password !== $confirm) {
			header("Location: ../Signup.php?signup=passwordnotmatch&Fullname=$Fullname&Username=$Username&useremail=$useremail&Phone=$Phone&StateOrigin=$StateOrigin");
			exit();
		}elseif (!in_array($StateOrigin, $states)) {
			header("Location: ../Signup.php?signup=invalidstate&Fullname=$Fullname&Username=$Username&useremail=$useremail&Phone=$Phone&StateOrigin=$StateOrigin");
			exit();
		}else{
			$date = getdate();
			$year = $date['year'];
			$year_valid = $year - 18;
			$input_date = explode("-", $_POST['dob']);
			$input_year = $input_date[0];
			if ($input_year <=! $year_valid) {
				header("Location: ../Signup.php?signup=invaliddate&Fullname=$Fullname&Username=$Username&useremail=$useremail&Phone=$Phone&StateOrigin=$StateOrigin");
				exit();
			}else{
					$sql = "SELECT * FROM users WHERE Username='$Username';";
					$result = mysqli_query($conn,$sql);
					$result_check = mysqli_num_rows($result);
					if ($result_check > 0) {
						header("Location: ../Signup.php?signup=usernameused&Fullname=$Fullname&Username=$Username&useremail=$useremail&Phone=$Phone&StateOrigin=$StateOrigin");
						exit();
					}else{
					$sql = "SELECT * FROM users WHERE Email='$useremail';";
					$result = mysqli_query($conn,$sql);
					$result_check = mysqli_num_rows($result);
					if ($result_check > 0) {
						header("Location: ../Signup.php?signup=emailused&Fullname=$Fullname&Username=$Username&useremail=$useremail&Phone=$Phone&StateOrigin=$StateOrigin");
						exit();
					}else{
					$sql = "SELECT * FROM users WHERE Phone='$Phone';";
					$result = mysqli_query($conn,$sql);
					$result_check = mysqli_num_rows($result);

					if ($result_check > 0) {
						header("Location: ../Signup.php?signup=phoneused&Fullname=$Fullname&Username=$Username&useremail=$useremail&Phone=$Phone&StateOrigin=$StateOrigin");
						exit();
					}else{
						$sql = "INSERT INTO users(FullName,Username,Email,Password,Phone,DOB,State) VALUES(?,?,?,?,?,?,?);";
						$stmt = mysqli_stmt_init($conn);

						//preparing the prepared statement
						if (!mysqli_stmt_prepare($stmt,$sql)) {
							header("Location: ../Signup.php?signup=notprepared1");
							exit();
						}else{
							$passwordDb = password_hash($password, PASSWORD_DEFAULT);
							mysqli_stmt_bind_param($stmt,"sssssss",$Fullname,$Username,$useremail,$passwordDb,$Phone,$dob,$StateOrigin);
							mysqli_stmt_execute($stmt);

							$sql = "SELECT * FROM users WHERE Username = '$Username' AND Email = '$useremail';";
							$result = mysqli_query($conn,$sql);

							while ($row = mysqli_fetch_assoc($result)) {
								session_start();

								$_SESSION['userid'] =  $row['id'];
								$_SESSION['username'] = $row['Username'];
								$_SESSION['name'] = $row['FullName'];
								$_SESSION['email']  = $row['Email'];
								$_SESSION['dob'] = $row['DOB'];
								$_SESSION['phone'] = $row['Phone'];
								$_SESSION['state'] = $row['State'];

								// Database Reg Number Check
							function Regcheck($conn,$randstr){
								$sql = "SELECT * FROM user_profile;";
								$result = mysqli_query($conn,$sql);
								while ( $row = mysqli_fetch_assoc($result)) {
									if ($row['Reg_No'] == $randstr) {
										$checkreg = 1;
										break;
									}else{
										$checkreg = 0;
									}
								}
								return $checkreg;
							}

							//Registration Number Generator
							function Genkey($conn){
								$keylength = 4;
								$getdate = getdate();
								$constantkey = $getdate['year'].$getdate['yday'];
								$shufflelist = '0123456789';
								$shufflekey = substr(str_shuffle($shufflelist),0,$keylength) ;
								$randstr = $constantkey.$shufflekey;
								$checkregno = Regcheck($conn,$randstr);

								 while ($checkregno == 1) {
								 	$shufflekey = substr(str_shuffle($shufflelist),0,$keylength) ;
									$randstr = $constantkey.$shufflekey;
									$checkregno = Regcheck($conn,$randstr);
								}
								return $randstr;
							}

							$regno = Genkey($conn);
							$sql = "INSERT INTO user_profile(user_id,Profile_img_stat,Reg_No) VALUES(?,?,?);";

							$stmt = mysqli_stmt_init($conn);
							//checking if the prepared statement will work
							if (!mysqli_stmt_prepare($stmt,$sql)) {
								header("Location:index.php?signup=regnoerror");
								exit();
							}else{
								$id = $_SESSION['userid'];
								$profile = 0;
								mysqli_stmt_bind_param($stmt,"sss",$id,$profile,$regno);
								mysqli_stmt_execute($stmt);

								$_SESSION['regno'] = $regno;

								// $header = "From: Noreply@Maraine.com";
								// $emailto = $useremail;
								// $subject = "Welcome to the train";
								// $message =  "<p>Hey ".$Fullname."</p>"."<p> Welcome to the family of managers. An account has been created with this email:".$useremail."</p>"."<p>Your Registration number is:".$regno."<br> NB: You can't make changes to your registration number. If you have any issues or questions, Do refer to our support team via the email Support@Maraine.com</p>";
								// mail($emailto, $subject, $message,$header);
							}

							}
						}
					}
					}
			}

		}
	}
}

	header("Location: ../index.php?signup=success");
