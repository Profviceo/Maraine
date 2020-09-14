<?php

	if (!isset($_POST['updateproimg'])) {
		header("Location: ../accountdetails.php?imgupdate=submit");
		exit();
	}else{
	
   session_start();
    require_once 'dbh.inc.php';
    $userid = $_SESSION['userid'];
    $file = $_FILES['file'];
    $fileName = mysqli_real_escape_string($conn,$_FILES['file']['name']);
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileerror = $_FILES['file']['error'];

    $allowed = array("jpg","png","jpeg");
    $fileExt = explode(".", $fileName);
    $fileRealExt = strtolower($fileExt[1]);

     if (empty($fileName)) {
    	header("Location: ../accountdetails.php?imgupdate=nofile");
    	exit();
    }elseif (!in_array($fileRealExt,$allowed)) {
    	header("Location: ../accountdetails.php?imgupdate=notallowed");
    	exit();
    }elseif ($fileSize > 5000000) {
    	header("Location: ../accountdetails.php?imgupdate=filetoobig");
    	exit();
    }else{

    	$filedestination = "../img/profile".$userid.".jpg";
    	move_uploaded_file($fileTmpName, $filedestination);


    	$sql = "UPDATE user_profile SET Profile_img_stat = ? WHERE user_id=?;";
    	$stmt = mysqli_stmt_init($conn);

    	//preparing statement
    	if (!mysqli_stmt_prepare($stmt,$sql)) {
    		header("Location: ../accountdetails.php?imgupdate=notprepared");
    		exit();
    	}else{
    		$Profile_img_stat = 1;
    		mysqli_stmt_bind_param($stmt, "is",$Profile_img_stat,$userid);
    		mysqli_stmt_execute($stmt);

    			}
    		}
    	}
    
    header("Location: ../accountdetails.php?imgupdate=success");
