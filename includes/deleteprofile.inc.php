<?php

    session_start();
    require_once 'Autoloader.inc.php';

    if(!isset($_POST['delete'])){
        header("Location: ../accountdetails.php");
        exit();
    }else{
        
        $filename = "profile".$_SESSION['userid'].".jpg";
        $filepath = "../img/".$filename;
        
        if(!unlink($filepath)){
            header("Location: ../accountdetails.php?delete=failed");
            exit();
        }else{
        $Delete = new class(){
            public function DeleteProfile(){
                $pdo = new Dbh();
                $sql = "UPDATE user_profile SET Profile_img_stat = 0";
                $query = $pdo->Connect()->query($sql);
            }
        };
        $Delete->DeleteProfile();
        header("Location: ../accountdetails.php?delete=success");
    }
}