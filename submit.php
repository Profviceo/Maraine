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
<section class="submit">
    <form method="POST" action="includes/submit.inc.php" enctype="multipart/form-data">
    <label for="AssignId">Assignment Id</label><br>
    <input type="text" name="AssignId" placeholder="Assignment Id"><br>
    <label for="Lecturer">Lecturer</label><br>
    <input type="text" name="Lecturer" placeholder="Lecturer Name"><br>
    <label for="Course">Course</label><br>
    <input type="text" name="Course" placeholder="Course Name"><br>
    <label for="Assignment_File">Assignment File</label><br>
    <input type="file" name="Assignment_File" placeholder="Assignment_File Name"><br>
    <label for="Short_Note">Short Note</label><br>
    <textarea type="textarea" name="Short_Note" placeholder="Short Note" ></textarea><br>
    <a href=""><button type="submit" name="submit" value="submit">Submit</button></a>
    </form>
</section>
</div>