<?php

    session_start();
    require_once 'Autoloader.inc.php';

    $Tid = $_POST['Tid'];

    if(!isset($_POST['resolved'])){
        header("Location: ../ticket.php?Tid=$Tid");
        exit();
    }else{
        $active = 0;

        $Usercontr = new Usercontr();
        $Usercontr->TicketUpdater($active, $Tid);

        header("Location:  ../ticket.php?Tid=$Tid");
    }