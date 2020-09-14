<?php

    session_start();
    require_once 'Autoloader.inc.php';

    $subject = $_POST['Subject'];
    $Related = $_POST['Related'];
    $Urgency = $_POST['Urgency'];
    $Message = $_POST['Message'];

    if(!empty($_FILES['File'])){
    $file = $_FILES['File'];
    $fileName = $_FILES['File']['name'];
    $fileTmp = $_FILES['File']['tmp_name'];
    $fileSize = $_FILES['File']['size'];
    $fileError =$_FILES['File']['error'];
    $ExtExplode = explode(".", $fileName);
    $fileExt = end($ExtExplode);
    $fileRealName = $subject.".".$_SESSION['username'].".".$fileExt;
    $fileDestination = "../uploads/".$fileRealName;
    $allowed = array("jpg","jpeg","png","webp");

    if($fileSize > 5000000){
        header("Location: ../subticket.php?submit=fileBig");
        exit();
    }elseif($fileError == 1){
        header("Location: ../subticket.php?submit=fileError");
        exit();
    }
     }

  
    
    if(empty($Related)){
        $Related = "Null";
    }elseif(empty($Urgency)){
        $Urgency = "Null";
    }elseif (condition) {
        # code...
    }


    $Validator = new Validator();
    $validate = $Validator->TicketValidator($subject, $Message);


    $TicketSubmitter = new Usercontr();
    $TicketSubmitter->TicketSubmitter($validate,$fileRealName, $fileTmp, $fileDestination , $subject, $Related, $Urgency, $Message);
