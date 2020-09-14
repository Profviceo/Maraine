<?php
  
  session_start();
  require_once "Autoloader.inc.php";


  $name = $_POST['fullname'];
  $dob = $_POST['Dob'];
  $inputstate = $_POST['state'];

    $Validator = new Validator();
    $validate = $Validator->MyAccountValidator($name, $dob, $inputstate);

    $Update = new Usercontr();
    $Update->ProfileStatUpdater($name, $dob, $inputstate, $validate);