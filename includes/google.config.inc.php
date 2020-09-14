<?php

    session_start();
    $url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    if(preg_match("/login\.php/", $url)){
        require_once 'googleApi/vendor/autoload.php';
    }else{
    require_once '../googleApi/vendor/autoload.php';
    }
    $gClient = new Google_Client();
    $gClient->SetClientId("523893021437-f8611ok7vpa12qi8pie7trktrrbk485b.apps.googleusercontent.com");
    $gClient->SetClientSecret("vIvWuCDz858qOvfdTWaP6o_W");
    $gClient->SetApplicationName("Maraine");
    $gClient->SetRedirectUri("https://localhost/maraine/includes/g-callback.inc.php");
    $gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me https://www.googleapis.com/auth/user.birthday.read https://www.googleapis.com/auth/user.phonenumbers.read https://www.googleapis.com/auth/profile.agerange.read");

