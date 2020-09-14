<?php

    session_start();
    require_once 'Autoloader.inc.php';

    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileerror = $_FILES['file']['error'];
    $fileExt = explode(".", $fileName);
    $fileRealExt = strtolower($fileExt[1]);

    $Validator = new Validator();
    $validate = $Validator->ProfileImgStat($fileName, $fileRealExt, $fileSize);

    $UpdateImg = new Usercontr();
    $UpdateImg->ProfileImgUpdater($validate, $fileTmpName);
