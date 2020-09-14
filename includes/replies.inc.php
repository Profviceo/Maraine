<?php

    session_start();
    require_once 'Autoloader.inc.php';


    $message = $_POST['customer_reply'];
    $Tid = $_POST['Tid'];
    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $Position = "student";
    $active = 2;

    if(!isset($_POST['submit'])){
        header("Location: ../ticket.php?Tid=$Tid&submit=submit");
        exit();
    }elseif (empty($message)) {
        header("Location: ../ticket.php?Tid=$Tid&submit=empty");
        exit();
    }elseif(!empty($fileName)){
        $fileTmp = $_FILES['file']['tmp_name'];
        $fileError = $_FILES['file']['error'];
        $fileSize = $_FILES['file']['size'];
        $fileExplode = explode(".", $fileName);
        $fileExt = strtolower(end($fileExplode));
        $fileRealName = $Tid.".".$_SESSION['username'].".".$fileExt;
        $fileDestination = "../uploads/".$fileRealName;
        $allowed = array("jpg","jpeg","png","webp");

        if(!in_array($fileExt, $allowed)){
            header("Location: ../ticket.php?Tid=$Tid&submit=notallowed");
            exit();
        }elseif ($fileSize > 5000000) {
            header("Location: ../ticket.php?Tid=$Tid&submit=toobig");
            exit();
        }elseif ($fileError == 1) {
            header("Location: ../ticket.php?Tid=$Tid&submit=error");
            exit();
        }else{
            move_uploaded_file($fileTmp, $fileDestination);
        }
    }elseif ($_SESSION['username'] == "admin") {
        $Position = "admin";
    }

    $Usercontr = new Usercontr();
    $Usercontr->TicketReplies($Tid, $message, $Position, $active);
    $Usercontr->TicketUpdater($active, $Tid);

    header("Location: ../ticket.php?Tid=$Tid&submit=success");