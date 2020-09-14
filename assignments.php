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
				<li class="assign">All Assignments</li>
				<a href="submitted.php"><li>Submitted Assignments</li></a>
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
				<th>Submission Date</th>
				<th>Assignment Id</th>
								
			<tr>
				<?php

				$GetCourses = new User();
				$GetCourse = $GetCourses->GetCourses();
				$GetCourseCount = count($GetCourse);

				if($GetCourseCount == 0){
					echo '<p class="error"> You have not registered any course</p>';
					exit();
				}elseif(isset($_GET['search'])){
					foreach ($GetCourse as $Course) {
						$search = $_GET['search'];
						$UserCourses = explode("," , $Course['courses']);
						$AssignmentSearch = new Userview();
						$Results = $AssignmentSearch->GetAllAssignmentSearch($search);
						$resultsCount = count($Results);

						if($resultsCount == 0 ){

							echo '<p class="error"> Opps! There was no result. Try searching for another keyword</p>';
						}else{
						foreach ($Results as $rowassign) {
						$aid = $rowassign['id'];
						$Lecturer = $rowassign['Lecturer'];
						$Course = $rowassign['Course'];
						echo '<td><a href="getwork.php?aid='.$aid.'">'.$rowassign['assign_title'].'</a></td>
						<td><a href="getwork.php?Lecturer='.$Lecturer.'">'.$rowassign['Lecturer'].'</a></td>
						<td><a href="getwork.php?Course='.$Course.'">'.$rowassign['Course'].'</a></td>
						<td><a href="getwork.php?aid='.$aid.'">'.$rowassign['Submissiondate'].'</a></td>
						<td><a href="getwork.php?aid='.$aid.'">'.$rowassign['id'].'</a></td>
					</tr>'; 
						}
						}
					}
					
					
				}else{

					$GetAssignments = new Userview();
					$Courses = $GetAssignments->Assignments();

					foreach($Courses as $Course){
						$CoursesDb = $GetCourses->GetAssignments($Course);
						foreach($CoursesDb as $rowassign){
						$aid = $rowassign['id'];
						$Lecturer = $rowassign['Lecturer'];
						$Course = $rowassign['Course'];
						echo '<td><a href="getwork.php?aid='.$aid.'">'.$rowassign['assign_title'].'</a></td>
						<td><a href="getwork.php?Lecturer='.$Lecturer.'">'.$rowassign['Lecturer'].'</a></td>
						<td><a href="getwork.php?Course='.$Course.'">'.$rowassign['Course'].'</a></td>
						<td><a href="getwork.php?aid='.$aid.'">'.$rowassign['Submissiondate'].'</a></td>
						<td><a href="getwork.php?aid='.$aid.'">'.$rowassign['id'].'</a></td>
					</tr>'; }
					}
				}

				?>
					<!-- <th>Assignment Title</th>
					<th>Lecturer</th>
					<th>Course</th>
					<th>Submission Date</th>
				
				<tr>
					<td><a href="index.php">This is just an example</a></td>
					<td><a href="#">Okwuchukwu Aturu</a></td>
					<td><a href="#">Business Study</a></td>
					<td><a href="#">02-02-2020</a></td>
				</tr>
				<tr>
					<td>Assignment Title</td>
					<td>Assignment Date</td>
					<td>Submission Date</td>
				</tr>

				<tr>
					<td>Assignment Title</td>
					<td>Assignment Date</td>
					<td>Submission Date</td>
				</tr>
			</table>
		</section>
	</div>
</body>
	</html> -->