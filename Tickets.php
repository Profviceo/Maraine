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
	
</head><body>
<?php
 require 'template.php';
?>
</div>
	<div class="wrapper">
		<section class="ul_container">
		<ul>
			 <a href="Tickets.php"><li class="assign">All Tickets</li></a>
			<a href="Tickets.php?true"><li>Resolved Tickets</li></a>
			<a href="Tickets.php?false"><li>Unresolved Tickets</li></a>

			</ul>
			<form>
				<input type="search" name="search" placeholder="Search">
				<button type="submit" name="submit">Search</button>
			</form>
			<a href="subticket.php"><button type="submit" name="submit">Submit Ticket</button></a>
		</section>
		<section class="longrow">
			<table>
				<th>Ticket Subject</th>
				<th>Date Submitted</th>
				<th>Status</th>
				<th>Urgency Level</th>		
			<tr>
		<?php

			$url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$tickets = new User();

			if(preg_match("/false/", $url)){
			
			$results = $tickets->GetActiveTickets();
			$count = count($results);

			if($count > 0){

				foreach ($results as $rowassign) {
					if($rowassign['is_active'] == 0){
						$status = "Resolved";
					}elseif($rowassign['is_active'] == 1){
						$status = "Active";
					}elseif($rowassign['is_active'] == 2){
						$status = "In Progress";
					}
					$id = $rowassign['id'];
					echo '<td><a href="ticket.php?Tid='.$id.'">'.$rowassign['Subject'].'</a></td>
						<td><a href="ticket.php?Tid='.$id.'">'.$rowassign['Date'].'</a></td>
						<td><a href="ticket.php?Tid='.$id.'">'.$status.'</a></td>
						<td><a href="ticket.php?Tid='.$id.'">'.$rowassign['Urgency'].'</a></td>
					</tr>';
				}
			}else{
				echo '<p class="error"> Opps! There was no result.</p>';
			}
			}elseif (preg_match("/true/", $url)) {
				$results = $tickets->GetResolvedTickets();
				$count = count($results);

				if($count > 0){

					foreach ($results as $rowassign) {
						if($rowassign['is_active'] == 0){
							$status = "Resolved";
						}elseif($rowassign['is_active'] == 1){
							$status = "Active";
						}elseif($rowassign['is_active'] == 2){
							$status = "In Progress";
						}
						$id = $rowassign['id'];
						echo '<td><a href="ticket.php?Tid='.$id.'">'.$rowassign['Subject'].'</a></td>
							<td><a href="ticket.php?Tid='.$id.'">'.$rowassign['Date'].'</a></td>
							<td><a href="ticket.php?Tid='.$id.'">'.$status.'</a></td>
							<td><a href="ticket.php?Tid='.$id.'">'.$rowassign['Urgency'].'</a></td>
						</tr>';
					}
				}else{
						echo '<p class="error"> Opps! There was no result.</p>';
					}
			}elseif(isset($_GET['search'])){
				$search = $_GET['search'];

				$results = $tickets->GetSearchTickets($search);
				$count = count($results);

				if($count > 0){

					foreach ($results as $rowassign) {
						if($rowassign['is_active'] == 0){
							$status = "Resolved";
						}elseif($rowassign['is_active'] == 1){
							$status = "Active";
						}elseif($rowassign['is_active'] == 2){
							$status = "In Progress";
						}
						$id = $rowassign['id'];
						echo '<td><a href="ticket.php?Tid='.$id.'">'.$rowassign['Subject'].'</a></td>
							<td><a href="ticket.php?Tid='.$id.'">'.$rowassign['Date'].'</a></td>
							<td><a href="ticket.php?Tid='.$id.'">'.$status.'</a></td>
							<td><a href="ticket.php?Tid='.$id.'">'.$rowassign['Urgency'].'</a></td>
						</tr>';
					}
				}else{
						echo '<p class="error"> Opps! There was no result.</p>';
					}

			}else{
			
			$results = $tickets->GetTickets();
			$count = count($results);
			
			if($count > 0){

				foreach ($results as $rowassign) {
					if($rowassign['is_active'] == 0){
						$status = "Resolved";
					}elseif($rowassign['is_active'] == 1){
						$status = "Active";
					}elseif($rowassign['is_active'] == 2){
						$status = "In Progress";
					}
						$id = $rowassign['id'];
						echo '<td><a href="ticket.php?Tid='.$id.'">'.$rowassign['Subject'].'</a></td>
							<td><a href="ticket.php?Tid='.$id.'">'.$rowassign['Date'].'</a></td>
							<td><a href="ticket.php?Tid='.$id.'">'.$status.'</a></td>
							<td><a href="ticket.php?Tid='.$id.'">'.$rowassign['Urgency'].'</a></td>
						</tr>';
				}
			}else{
				echo '<p class="error"> Opps! There was no result. Try searching for another keyword</p>';
			}
		}
		?>