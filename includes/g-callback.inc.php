<?php

    require_once 'google.config.inc.php';
    require_once 'Autoloader.inc.php';

    if(isset($_SESSION['access_token'])){
        $gClient->SetAccessToken($_SESSION['access_token']);
    }elseif (isset($_GET['code'])) {
        $token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
        $_SESSION['access_token'] = $token;
    }

    $oauth = new Google_Service_Oauth2($gClient);
    $userdata = $oauth->userinfo_v2_me->get();

    $_SESSION['username'] = $userdata['given_name'];
    $_SESSION['Fullname'] = $userdata['name'];
    $_SESSION['img'] = $userdata['picture'];
     $_SESSION['email'] = $userdata['email'];
       $_SESSION['password'] = $userdata['id'];
       $confirm = $_SESSION['password'];
       $Phone = "Not Set";
       $getdate = getdate();
       $dob = $getdate['year']."-".$getdate['mon']."-".$getdate['mday'];
       $state = "Not set";

       
        
   $GetUsers = new User();
   $Users = $GetUsers->GetEmails($_SESSION['email']);
   $count = count($Users);

   
   if ($count > 0) {
      
    foreach ($Users as $User) {
        $_SESSION['userid'] = $User['id'];
		$_SESSION['name'] = $User['FullName'];
		$_SESSION['username'] = strtolower($User['Username']);
		$_SESSION['email'] = $User['Email'];
		$_SESSION['dob'] = $User['DOB'];
		$_SESSION['phone'] = $User['Phone'];
        $_SESSION['state'] = $User['State'];

        $RegNos = $GetUsers->GetUserRegNoId($_SESSION['userid']);

        foreach($RegNos as $Regno){
            $_SESSION['regno'] = $Regno['Reg_No'];
        }
        header("Location: ../index.php");
    }
   }elseif ($count == 0) {
       
    // $Validator = new Validator();
	// $Validator->SignupValues($_SESSION['Fullname'], $_SESSION['username'], $_SESSION['email'], $password, $confirm, $Phone, $dob, $state);
    // $Validate = $Validator->Signupvalidate();
    $Validate = "Yes";


	$Signup = new Usercontr;
	$Signup->SignupValuesConfirmed($_SESSION['Fullname'], $_SESSION['username'], $_SESSION['email'], $_SESSION['password'], $confirm, $Phone, $dob, $state);
    $Signup->Signup($Validate);
    
    header("Location: ../index.php");
   }