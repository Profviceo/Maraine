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
	<link rel="stylesheet" type="text/css" href="css/getwork.css">
	

</head><body>
<?php
 require 'template.php';
?>
</div>
	<div class="wrapper">
		
		<section class="getwork">
			<?php

			if (isset($_GET['aid'])) {
			$aid = $_GET['aid'];
			$GetAssignment = new Userview();
			$Assignments = $GetAssignment->GetAssignmentsId($aid);
			$AssignmentsCount = count($Assignments);

			
			if($AssignmentsCount > 0){
				foreach ($Assignments as $row) {
					try {
						$filePath = "uploads/".$row['Filename']."*";
						$FileFind = glob($filePath);
						$FileUrl = $FileFind[0];

						echo "<h1>Course Title: ".$row['Course']."</h1><br>";
						echo "<h2> Assignment Title: ".$row['assign_title']."</h2><br>";
						echo "<h3> This assignment was given by ".$row['Lecturer']."</h3><br>";
						echo "<p> Your expected to submit this assignment on or before ".$row['Submissiondate'].". Click on the button below to download the assignment File</p><br>";
						echo '<a href="'.$FileUrl.'" download><button>Download</button></a>';
					} catch (PDOexception $e) {
						echo '<p class="error"> There was an error retreiving the data</p>';
					}
					
				}
			}else {
				header("Location: assignments.php?get=doesnotexist");
				exit();
			}
			}elseif (isset($_GET['Lecturer'])) {
				$lecturer = $_GET['Lecturer'];
				
				$GetAssignment = new Userview();
				$LecturersWorks = $GetAssignment->GetAssignmentsLecturer($lecturer);
				$Count = count($LecturersWorks);

				if($Count > 0){
					
					foreach($LecturersWorks as $row){
						$filePath = "uploads/".$row['Filename']."*";
						$FileFind = glob($filePath);
						$FileUrl = $FileFind[0];

						echo "<h1>Course Title: ".$row['Course']."</h1><br>";
						echo "<h2> Assignment Title: ".$row['assign_title']."</h2><br>";
						echo "<h3> This assignment was given by ".$row['Lecturer']."</h3><br>";
						echo "<p> Your expected to submit this assignment on or before ".$row['Submissiondate'].". Click on the button below to download the assignment File</p><br>";
						echo '<a href="'.$FileUrl.'"><button>Download</button></a>';
					}
				}else {
					header("Location: assignments.php?get=doesnotexist");
					exit();
				}

			}elseif (isset($_GET['Course'])) {
				$Course = $_GET['Course'];
				
				$GetAssignment = new Userview();
				$CourseAssign = $GetAssignment->GetAssignmentsCourse($Course);
				$Count = count($CourseAssign);

				if($Count > 0){
					foreach($CourseAssign as $row){

						$filePath = "uploads/".$row['Filename']."*";
						$FileFind = glob($filePath);
						$FileUrl = $FileFind[0];

						echo "<h1>Course Title: ".$row['Course']."</h1><br>";
						echo "<h2> Assignment Title: ".$row['assign_title']."</h2><br>";
						echo "<h3> This assignment was given by ".$row['Lecturer']."</h3><br>";
						echo "<p> Your expected to submit this assignment on or before ".$row['Submissiondate'].". Click on the button below to download the assignment File</p><br>";
						echo '<a href="'.$FileUrl.'"><button>Download</button></a>';
					}

				}else {
					header("Location: assignments.php?get=doesnotexist");
					exit();
				}
			}else {
				header("Location: assignments.php?get=doesnotexist");
				exit();
			}
			

		?>

		
		</section>
	</div>

</body>