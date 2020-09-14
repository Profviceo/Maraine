<?php
  if (!isset($_POST)) {
    header("Location: ../accountdetails.php?update=submit");
    exit();
  }else{
    session_start();

    require 'dbh.inc.php';
    $name = mysqli_real_escape_string($conn,$_POST['fullname']);
    $dob = mysqli_real_escape_string($conn,$_POST['Dob']);
    $inputstate = mysqli_real_escape_string($conn,$_POST['state']);
    $userid = $_SESSION['userid'];
    $useremail = $_SESSION['email'];
    $StateOrigin = str_replace(" ", "", $inputstate);
    $state = strtolower($StateOrigin);
    $states = array("abia","abuja","adamawa","akwa ibom" ,"anambra","bauchi","bayelsa","benue","borno","cross river","delta","ebonyi","edo","ekiti","enugu","gombe","imo","jigawa","kaduna","kano","katsina","kebbi","kogi","kwara","lagos","nasarawa","niger","ogun","ondo","osun","oyo","plateau","rivers","sokoto","taraba","yobe","zamfara");
    
    if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
      header("Location: ../accountdetails.php?update=invalidchar");
      exit();
    }elseif (!in_array($state, $states)) {
     header("Location: ../accountdetails.php?update=invalidstate");
      exit();
    }else{
      $date = getdate();
      $year = $date['year'];
      $year_valid = $year - 18;
      $input_date = explode("-", $dob);
      $input_year = $input_date[0];
      if ($input_year > $year_valid) {
        header("Location: ../accountdetails.php?update=dateinvalid");
        exit();
    }else{

    $sql = "SELECT * FROM updateprofile WHERE userid = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt,$sql)) {
      header("Location: ../accountdetails.php?update=notprepared");
      exit();
    }else{
      mysqli_stmt_bind_param($stmt,"i",$userid);
      mysqli_stmt_execute($stmt);

      $result = mysqli_stmt_get_result($stmt);
      $resultcheck = mysqli_num_rows($result);

      if ($resultcheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
         if ($row['profilestatus'] == 1) {
          header("Location: ../accountdetails.php?update=donebefore");
         }elseif ($row['profilestatus'] == 0) {
           if (empty($name)) {
             $name = $_SESSION['name'];
           }elseif (empty($dob)) {
             $dob =  $_SESSION['dob'];
           }elseif (empty($state)) {
             $state = $_SESSION['state'];
           }

           $sql = "UPDATE users SET FullName = ?, dob = ? , State = ? WHERE id = ?;";
           $stmt = mysqli_stmt_init($conn);

           if (!mysqli_stmt_prepare($stmt,$sql)) {
             header("Location: ../accountdetails.php?update=notprepared");
             exit();
           }else{
            mysqli_stmt_bind_param($stmt,"sssi",$name,$dob,$state,$userid);
            mysqli_stmt_execute($stmt);

            $sql = "UPDATE updateprofile SET profilestatus = '1' WHERE userid = '$userid';";
            mysqli_query($conn,$sql);

            header("Location: ../accountdetails.php?update=success");
           }
         }
        }
      
   
      

      }else{
        if (empty($name)) {
             $name = $_SESSION['name'];
           }elseif (empty($dob)) {
             $dob =  $_SESSION['dob'];
           }elseif (empty($state)) {
             $state = $_SESSION['state'];
           }

           $sql = "UPDATE users SET FullName = ?, dob = ? , State = ? WHERE id = ?;";
           $stmt = mysqli_stmt_init($conn);

           if (!mysqli_stmt_prepare($stmt,$sql)) {
             header("Location: ../accountdetails.php?update=notprepared");
             exit();
           }else{
            mysqli_stmt_bind_param($stmt,"sssi",$name,$dob,$state,$userid);
            mysqli_stmt_execute($stmt);

            $sql = "INSERT INTO updateprofile(useremail,userid,profilestatus,emailstatus,Token,Selector) VALUES(?,?,?,?,?,?);";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt,$sql)) {
              header("Location: ../accountdetails.php?update=notprepared");
              exit();
            }else{
              $profilestatus = 1;
              $emailstatus = 0;
              $Token = "empty";
              $Selector = "empty";
              mysqli_stmt_bind_param($stmt,"ssssss",$useremail,$userid,$profilestatus,$emailstatus,$Token,$Selector);
              mysqli_stmt_execute($stmt);

              header("Location: ../accountdetails.php?update=success");
              exit();
            }
            
      }
}

  }
}
}
}



