<?php

    session_start();
    require_once 'Autoloader.inc.php';

    $Aid = $_POST['AssignId'];
    $Lecturer = $_POST['Lecturer'];
    $Course = $_POST['Course'];
    $File = $_FILES['Assignment_File'];
    $Short_Note = $_POST['Short_Note'];
    
    $fileName = $_FILES['Assignment_File']['name'];
    $fileExtExplode = explode(".",$fileName);
    $fileRealExt = $fileExtExplode[1];
    $fileSize = $_FILES['Assignment_File']['size'];
    $fileError = $_FILES['Assignment_File']['error'];
    $fileTmp = $_FILES['Assignment_File']['tmp_name'];
    $Date = getdate();
    $CurrentDate = $Date['year']."-".$Date['mon']."-".$Date['mday'];
    $FileRealName = $_SESSION['username'].$_SESSION['regno'].".".$Aid.".".$fileRealExt;
    $FileDestination = "../uploads/".$FileRealName;

    $Validator = new Validator();
    $validate = $Validator->AssignmentValidator($Aid, $Lecturer, $Course, $fileName, $fileSize, $fileError);

    $SubmitBot = new Usercontr();
    $SubmitBot->SubmitAssignment($validate,$Aid , $Course, $Short_Note, $FileRealName, $fileTmp, $FileDestination);
    

    
   
