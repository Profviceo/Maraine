<?php

	session_start();
	if (!isset($_SESSION['username'])) {
		header("Location: login.php?notallowed");
		exit();
	}
	require_once 'includes/Autoloader.inc.php';

?>

<!DOCTYPE html>
<html>
<head>
	<title>Maraine School Of Management</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Maraine School Of Management is a template built by Viceo while he was yet starting out in his programmin journey">
	<meta name="author" content="Viceo">
	<link rel="icon" type="shortcut-icon" href="img/favicon.png">
	<link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/assignments.css">
    <link rel="stylesheet" type="text/css" href="css/ticket.css">
	
</head><body>
<?php
 require 'template.php';
?>
</div>
	<div class="wrapper">
		<section class="ul_container">
		<ul>
					<a href="Tickets.php"><li>All Tickets</li></a>
					<a href="Tickets.php?true"><li>Resolved Tickets</li></a>
					<a href="Tickets.php?false"><li>Unresolved Tickets</li></a>
				
			</ul>
			<a href="subticket.php"><button type="submit" name="submit">Submit Ticket</button></a>
        </section>
        
        <section class="ticket_flow">
            <section class="ticket_flow_right">

                <?php

                    $Tid = $_GET['Tid'];
                    $tickets = new User();
                    $results = $tickets->GetTicketsId($Tid);
                    
                    foreach ($results as $result) {
                        
                    }

                ?>
                
                <h1>Subject: <?php echo $result['Subject'] ?></h1>
                <p>Submitted <small><i><?php echo $result['Date'] ?></i></small> || Your Message :<br><br><br> <?php echo $result['Message'] ?></p>

                <?php

                    $User = new Userview();
                    $tickets = $User->GetTicketReply($Tid);
                    $countTicket = count($tickets);

                    if($countTicket > 0){
                        foreach ($tickets as $row) {
                            if ($row['Position'] == "student") {
                                echo '<h1>Your Reply</h1>
                                <p>Submitted <small><i>'.$row['Date'].'</i></small> || Your Reply :<br><br><br> '.$row['Message'].' </p>';
                            }elseif($row['Position'] == "admin"){
                                echo '<h1>Support Team reply</h1>
                                <p>Submitted <small><i>'.$row['Date'].'</i></small> || Admin Reply :<br><br><br> '.$row['Message'].'<br><br><br>
                                Best Regards<br>
                                Victor<br>
                                Maraine Support Team
                                </p>';
                            }
                        }
                    }
                ?>

                <?php 

                    if($result['is_active'] == 1 || $result['is_active'] == 2){
                        echo '
                        <h1>Reply</h1>
                        <form method="POST" action="includes/replies.inc.php" enctype="multipart/form-data">
                        <textarea name="customer_reply" placeholder="Type here to reply......."></textarea>
                        <input type="text" name="Tid" value= "'.$result['id'].'"  hidden>
                        <input type="file" name="file">
                        <button type="submit" name="submit">Submit</button>
                        </form>';
                    }
                ?>

               

                

            </section>
            <section class="ticket_flow_left">
                <img src="img/todo.png" alt="Todo List">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam eius id dolores doloribus itaque quae adipisci impedit saepe dignissimos laborum ullam minima officiis voluptate, pariatur tenetur unde, placeat at? Dolor?</p>
                    <Br><br><br>
                <h3>If your issue has been resolved, Please close the ticket by clicking on the button below</h3>

                <form method="POST" action="includes/resolved.inc.php" > 
                <input type="text" name="Tid" value="<?php echo $_GET['Tid'] ?>" hidden>
                <button type="submit" name="resolved">Resolved</button>
                </form>

            </section>
        </section>

    </div>