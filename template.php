<body>
	<div class="main">
		<div class="body-1">
			<div class="container">
				<div class="container-1">
					<?php
					require_once 'includes/dbh.inc.php';
					$sql = "SELECT * FROM user_profile WHERE user_id = ?;";
					$stmt = mysqli_stmt_init($conn);

					//preparing prepared statement
					if (!mysqli_stmt_prepare($stmt,$sql)) {
						'<img src="img/profile.png">Change Profile Image<label></label><br>';
					}else{
						$userid = $_SESSION['userid'];
						mysqli_stmt_bind_param($stmt, "s",$userid);
						mysqli_stmt_execute($stmt);

						$result = mysqli_stmt_get_result($stmt);
						while ($row = mysqli_fetch_assoc($result)) {
							if ($row['Profile_img_stat'] == 0) {
								echo '<div class="container-1"><a href="#"><img src="img/profile.png" class="profile_img"><br><br>YOUR PROFILE</a></div>';
							}else{
								echo '<div class="container-1" ><a href="#"><img src="img/profile'.$_SESSION['userid'].'.jpg?'.mt_rand().'" class="profile_img"><br><br>YOUR PROFILE</a></div>';
							}
						}

					}
				?>
				</div>
	<div class="container-2">
	<ul>

		<?php

		$url = "https://.$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		
		if (preg_match("/index/", $url)) {
			echo '<li class="active"><a href="index.php">Home</a></li>
		<li><a href="#">FEES/PAYMENTS</a></li>
		<li><a href="assignments.php">ASSIGNMENT<sup class="bell">1</sup></a></li>
		<li><a href="tickets.php">MY SUPPORT</a></li>
		<li ><a href="accountdetails.php">MY ACCOUNT</a></li>
		<li><a href="includes/logout.inc.php?logout=valid">LOGOUT</a></li>';
		}elseif (preg_match("/accountdetails/", $url)) {
			echo '
		<li><a href="index.php">Home</a></li>
		<li><a href="#">FEES/PAYMENTS</a></li>
		<li><a href="assignments.php">ASSIGNMENT<sup class="bell">1</sup></a></li>
		<li><a href="tickets.php">MY SUPPORT</a></li>
		<li class="active"><a href="accountdetails.php">MY ACCOUNT</a></li>
		<li><a href="includes/logout.inc.php?logout=valid">LOGOUT</a></li>';
		}elseif (preg_match("/assignments/", $url)) {
			echo '<li><a href="index.php">Home</a></li>
		<li><a href="#">FEES/PAYMENTS</a></li>
		<li  class="active"><a href="assignments.php">ASSIGNMENT<sup class="bell">1</sup></a></li>
		<li><a href="tickets.php">MY SUPPORT</a></li>
		<li ><a href="accountdetails.php">MY ACCOUNT</a></li>
		<li><a href="includes/logout.inc.php?logout=valid">LOGOUT</a></li>';
		}elseif (preg_match("/submitted/", $url)) {
			echo '<li><a href="index.php">Home</a></li>
		<li><a href="#">FEES/PAYMENTS</a></li>
		<li  class="active"><a href="assignments.php">ASSIGNMENT<sup class="bell">1</sup></a></li>
		<li><a href="tickets.php">MY SUPPORT</a></li>
		<li ><a href="accountdetails.php">MY ACCOUNT</a></li>
		<li><a href="includes/logout.inc.php?logout=valid">LOGOUT</a></li>';
		}elseif (preg_match("/submit\.php/", $url)) {
			echo '<li><a href="index.php">Home</a></li>
		<li><a href="#">FEES/PAYMENTS</a></li>
		<li  class="active"><a href="assignments.php">ASSIGNMENT<sup class="bell">1</sup></a></li>
		<li><a href="tickets.php">MY SUPPORT</a></li>
		<li ><a href="accountdetails.php">MY ACCOUNT</a></li>
		<li><a href="includes/logout.inc.php?logout=valid">LOGOUT</a></li>';
		}elseif (preg_match("/getwork\.php/", $url)) {
			echo '<li><a href="index.php">Home</a></li>
		<li><a href="#">FEES/PAYMENTS</a></li>
		<li  class="active"><a href="assignments.php">ASSIGNMENT<sup class="bell">1</sup></a></li>
		<li><a href="tickets.php">MY SUPPORT</a></li>
		<li ><a href="accountdetails.php">MY ACCOUNT</a></li>
		<li><a href="includes/logout.inc.php?logout=valid">LOGOUT</a></li>';
		}elseif (preg_match("/(icket)\.php/", $url) || preg_match("/(ickets)\.php/", $url)) {
			echo '<li><a href="index.php">Home</a></li>
		<li><a href="#">FEES/PAYMENTS</a></li>
		<li><a href="assignments.php">ASSIGNMENT<sup class="bell">1</sup></a></li>
		<li  class="active"><a href="tickets.php">MY SUPPORT</a></li>
		<li ><a href="accountdetails.php">MY ACCOUNT</a></li>
		<li><a href="includes/logout.inc.php?logout=valid">LOGOUT</a></li>';
		}
		else{
			echo '<li class="active"><a href="index.php">Home</a></li>
		<li><a href="#">FEES/PAYMENTS</a></li>
		<li><a href="assignments.php">ASSIGNMENT<sup class="bell">1</sup></a></li>
		<li><a href="tickets.php">MY SUPPORT</a></li>
		<li ><a href="accountdetails.php">MY ACCOUNT</a></li>
		<li><a href="includes/logout.inc.php?logout=valid">LOGOUT</a></li>';
		}

		
		?>
		

		
	</ul>
    </div>
	</div>

	<div class="body-2">
		<marquee class="header_marquee">You are welcomed to your dashboard. Please do all assignments assigned to you.
			 <?php
			  $currentime = getdate();
			 echo $currentime['year']."/".$currentime['month']."/".$currentime['mday']."/".$currentime['weekday'];
			 ?>
			 </marquee><br>
			 <div class="student_details">
			 	<ul>
			 		<li>Name: <?php
			 		if (!isset($_SESSION['name'])) {
			 		 	echo "";
			 		 } else{
			 		 	echo $_SESSION['name'];
			 		 }
			 		 ?></li>
			 		<li>Reg No: <?php
			 			if (!isset($_SESSION['regno'])) {
			 				echo "";
			 			}else{
			 				echo $_SESSION['regno'];
			 			}
			 		?></li>
			 		<li>Username: <?php
			 			if (!isset($_SESSION['username'])) {
			 				echo "";
			 			}else{
			 				echo $_SESSION['username'];
			 			}
			 		?></li>
			 		<li><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve" width="20px" height="20px" class=""><g><g>
	<g>
		<path d="M467.812,431.851l-36.629-61.056c-16.917-28.181-25.856-60.459-25.856-93.312V224c0-67.52-45.056-124.629-106.667-143.04    V42.667C298.66,19.136,279.524,0,255.993,0s-42.667,19.136-42.667,42.667V80.96C151.716,99.371,106.66,156.48,106.66,224v53.483    c0,32.853-8.939,65.109-25.835,93.291l-36.629,61.056c-1.984,3.307-2.027,7.403-0.128,10.752c1.899,3.349,5.419,5.419,9.259,5.419    H458.66c3.84,0,7.381-2.069,9.28-5.397C469.839,439.275,469.775,435.136,467.812,431.851z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#FFA500"/>
	</g>
</g><g>
	<g>
		<path d="M188.815,469.333C200.847,494.464,226.319,512,255.993,512s55.147-17.536,67.179-42.667H188.815z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#FFA500"/>
	</g>
</g></g> </svg><sup class="bell">1</sup></li>
			 	</ul>

			 </div>
	</div>
</div>


