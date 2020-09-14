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
				<a href="assignments.php"><li>All Assignments</li></a>
				<li class="assign">Submitted Assignments</li>
				<li> Lecturers Notes</li>
			</ul>
			<form>
				<input type="search" name="search" placeholder="Search">
				<button type="submit" name="submit">Search</button>
			</form>
			<a href="submit.php"><button type="submit" name="submit">Submit Assignment</button></a>
		</section>
		<section class="longrow">
			<table>
				<th>Assignment Title</th>
				<th>Lecturer</th>
				<th>Course</th>
				<th>Date Submitted</th>
                <th>Assignment Id</th>
                <th>Short Note</th>
								
			<tr>
        <?php

            $Submitted = new User();
            $SubmittedAssignments = $Submitted->GetSubmittedAssignmentUser();
			$count = count($SubmittedAssignments);
			if($count == 0 ){
				echo '<p class="error">You have no Submitted Assignments</p>';
				exit();
			}elseif (isset($_GET['search'])) {
                $search = strtolower($_GET['search']);
                $searchResult = new Userview();
				$results = $searchResult->GetSubmittedAssignmentSearch($search);
				$count = count($results);

				if ($count > 0) {
					foreach($results as $row){
						$aid = $row['Assign_Id'];
						$object = new Userview();
						$Submits = $object->GetAssignmentsId($aid);
	
						foreach($Submits as $rowassign){
							$aid = $rowassign['id'];
							$Lecturer = $rowassign['Lecturer'];
							$Course = $rowassign['Course'];	

							echo '<td><a href="getwork.php?aid='.$aid.'">'.$rowassign['assign_title'].'</a></td>
                    <td><a href="getwork.php?Lecturer='.$Lecturer.'">'.$rowassign['Lecturer'].'</a></td>
                    <td><a href="getwork.php?Course='.$Course.'">'.$rowassign['Course'].'</a></td>
                    <td><a href="getwork.php?aid='.$aid.'">'.$row['DateSubmitted'].'</a></td>
                    <td><a href="getwork.php?aid='.$aid.'">'.$rowassign['id'].'</a></td>
                    <td><a href="getwork.php?aid='.$aid.'">'.$row['Short_Note'].'</a></td>
                </tr>';
						}
					}
				}else{
					echo '<p class="error">Opps! No result was found. Try searching for something else</p>';
				}
            }else{
            if ($count > 0) {
                foreach($SubmittedAssignments as $row){
                    $aid = $row['Assign_Id'];
                    $object = new Userview();
                    $Submits = $object->GetAssignmentsId($aid);

                    foreach ($Submits as $rowassign) {
                    $aid = $rowassign['id'];
                    $Lecturer = $rowassign['Lecturer'];
                    $Course = $rowassign['Course'];

                    echo '<td><a href="getwork.php?aid='.$aid.'">'.$rowassign['assign_title'].'</a></td>
                    <td><a href="getwork.php?Lecturer='.$Lecturer.'">'.$rowassign['Lecturer'].'</a></td>
                    <td><a href="getwork.php?Course='.$Course.'">'.$rowassign['Course'].'</a></td>
                    <td><a href="getwork.php?aid='.$aid.'">'.$row['DateSubmitted'].'</a></td>
                    <td><a href="getwork.php?aid='.$aid.'">'.$rowassign['id'].'</a></td>
                    <td><a href="getwork.php?aid='.$aid.'">'.$row['Short_Note'].'</a></td>
                </tr>'; }}
            }else{
                echo '<p class="error">You have no Submitted Assignments</p>';
            }
        }
            
