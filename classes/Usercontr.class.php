<?php

	Class Usercontr extends User{

		protected $Fullname;
		protected $Username;
		protected $Useremail;
		protected $Password;
		protected $Confirm;
		protected $Phone;
		protected $Dob;
		protected $State;
		protected $StateOrigin;

		public function SignupValuesConfirmed($Fullname, $Username, $useremail, $password, $confirm, $Phone, $dob, $state){

		$this->Fullname =  $Fullname;
		$this->Username = $Username;
		$this->Useremail =  $useremail;
		$this->Password = $password;
		$this->Confirm =  $confirm;
		$this->Phone =  $Phone;
		$this->Dob =  $dob;
		$this->State = strtolower($state);
		$this->StateOrigin =  $this->State;

		 
		}

		public function Signup($validate){
			$conn = new Dbh();
			$pdo = $conn->Connect();
			
			if ($validate !== "Yes") {
			header("Location: ../Signup.php?signup=notprepared&Fullname=$this->Fullname&Username=$this->Username&useremail=$this->Useremail&Phone=$this->Phone&StateOrigin=$this->StateOrigin");
			exit();
			}else{
				try{
				$DbPassword = password_hash($this->Password, PASSWORD_DEFAULT);
				
				// $array = array($this->Fullname,$this->Username,$this->Useremail,$DbPassword,$this->Phone,$this->Dob,$this->State);
				// print_r($array);
				$sql = "INSERT INTO users(FullName,Username,Email,Password,Phone,DOB,State) VALUES(?,?,?,?,?,?,?);";
				$stmt = $pdo->prepare($sql);		
				$stmt->execute([$this->Fullname,$this->Username,$this->Useremail,$DbPassword,$this->Phone,$this->Dob,$this->State]);
				}catch(PDOexception $e){
					echo "Error:".$e;
				}
			

			$Users = $this->GetUsers($this->Username, $this->Useremail);

			foreach($Users as $User){
				$_SESSION['userid'] =  $User['id'];
				$_SESSION['username'] = $User['Username'];
				$_SESSION['name'] = $User['FullName'];
				$_SESSION['email']  = $User['Email'];
				$_SESSION['dob'] = $User['DOB'];
				$_SESSION['phone'] = $User['Phone'];
				$_SESSION['state'] = $User['State'];
			}
				
				$getregno = $this->GetRegNumbers();
				

			function Regcheck($randstr,$getregno){
								$rows = $getregno;
								foreach($rows as $row){
									if ($row['Reg_No'] == $randstr) {
										$checkreg = 1;
										break;
									}else{
										$checkreg = 0;
									}
								}
								return $checkreg;
							}

							//Registration Number Generator
							function Genkey($getregno){
								$keylength = 4;
								$getdate = getdate();
								$constantkey = $getdate['year'].$getdate['yday'];
								$shufflelist = '0123456789';
								$shufflekey = substr(str_shuffle($shufflelist),0,$keylength) ;
								$randstr = $constantkey.$shufflekey;
								$checkregno = Regcheck($randstr,$getregno);

								 while ($checkregno == 1) {
								 	$shufflekey = substr(str_shuffle($shufflelist),0,$keylength) ;
									$randstr = $constantkey.$shufflekey;
									$checkregno = Regcheck($randstr,$getregno);
								}
								return $randstr;
							}

							$regno = Genkey($getregno);
							$id = $_SESSION['userid'];
							$profile = 0;
							$profilestatus = 0;

							if (isset($_SESSION['img'])) {

								$url = $_SESSION['img'];
								$img= "../img/profile".$id.".jpg";
								file_put_contents($img, file_get_contents($url));

								$profile = 1;
								$sql = "INSERT INTO user_profile(user_id,Profile_img_stat,Reg_No,profilestatus) VALUES(?,?,?,?)";
								$stmt = $pdo->prepare($sql);
								$stmt->execute([$id, $profile, $regno, $profilestatus]);
							}else{
							$sql = "INSERT INTO user_profile(user_id,Profile_img_stat,Reg_No,profilestatus) VALUES(?,?,?,?)";
							$stmt = $pdo->prepare($sql);
							$stmt->execute([$id, $profile, $regno, $profilestatus]);
							
							}
							$_SESSION['regno'] = $regno;

							$to = $_SESSION['email'];
							$from = "info@Maraine.com";
							$reply = "info@Maraine.com";
							$header = "From: ".$from;
							$header .= "Reply-To: ".$from;
							$subject = "New User activation Notice!";
							$message = 'Hey '.$_SESSION['username'].'.<br><br><p> A new user has signed up on <a href = "http://maraine.infinityfreeapp.com/">Maraine.com</a> with this email. If that was you, you are welcomed to the home of managers. Your registration number is '.$_SESSION['regno'].'.<br><br><br><p> Best Regards<br>Victor<br><a href = "http://maraine.infinityfreeapp.com/">Maraine.com</a><p>';

							mail($to, $subject, $message, $header);
							
							  header("Location: ../index.php?signup=success");
		}
		}
		
		public function ProfileStatUpdater($Fullname, $Dob, $State, $validate){

			$pdo = new Dbh();
			$name = $Fullname;
		    $dob = $Dob;
		    $inputstate = $State;
		    $userid = $_SESSION['userid'];
		    $useremail = $_SESSION['email'];
		    $StateOrigin = str_replace(" ", " ", $inputstate);
		    $state = strtolower($StateOrigin);


			if ($validate !== "Yes" ) {
				header("Location: ../accountdetails.php?update=notprepared");
      			exit();
			}elseif(empty($name)){
				$name = $_SESSION['name'];
			}elseif(empty($dob)){
				$dob = $_SESSION['dob'];
			}elseif (empty($inputstate)) {
				$input = $_SESSION['state'];
			}else{
				$sql = "UPDATE users SET FullName = ?, dob = ? , State = ? WHERE id = ?";
				$stmt = $pdo->Connect()->prepare($sql);
				$stmt->execute([$name, $dob, $state, $userid]);

				$sql = "UPDATE user_profile SET profilestatus = '1' WHERE user_id = ?;";
				$stmt = $pdo->Connect()->prepare($sql);
				$stmt->execute([$userid]);
			}
			header("Location: ../accountdetails.php?update=success");
		}



		public function ProfileImgUpdater ($validate, $fileTmpName){

			$pdo = new Dbh();
			if ($validate !== "Yes") {
				header("Location: ../accountdetails.php?imgupdate=notprepared");
    			exit();
			}else{
				$filedestination = "../img/profile".$_SESSION['userid'].".jpg";
    			move_uploaded_file($fileTmpName, $filedestination);

    			$Profile_img_stat = 1;
    			$sql = "UPDATE user_profile SET Profile_img_stat = ? WHERE user_id=?";
    			$stmt = $pdo->Connect()->prepare($sql);
    			$stmt->execute([$Profile_img_stat, $_SESSION['userid']]);

    			header("Location: ../accountdetails.php?imgupdate=success");
			}
		}

		public function CourseRegistrar($validate, $Dbcourses){

			$pdo = new Dbh();

			if ($validate !== "Yes") {
				header("Location: ../course_register.php?register=notprepared2");
					exit();
			}else{
				$sql = "INSERT INTO courses(user_id,useremail,courses,empty) VALUES(?,?,?,?)";
				$stmt = $pdo->Connect()->Prepare($sql);
				$stmt->execute([$_SESSION['userid'], $_SESSION['email'], $Dbcourses, "Empty"]);

				header("Location: ../course_register.php?register=success");
			}
		}

		public function AssignWork($validate, $course,$lecturer ,$submission ,$title,$fileRealName, $fileTmp, $filedestination){

			$pdo = new Dbh();
			
			if($validate !== "Yes"){
				header("Location: ../assignwork.php?submit=notprepared");
				exit();
			}else{

				$test = array($validate, $course,$lecturer ,$submission ,$title,$fileRealName, $fileTmp, $filedestination);
				print_r($test);
				$sql = "INSERT INTO assign_given(Course,Lecturer,Submissiondate,assign_title, Filename) VALUES(?,?,?,?,?)";
				$stmt = $pdo->Connect()->prepare($sql);
				$stmt->execute([$course,$lecturer ,$submission ,$title , $fileRealName]);
				
				move_uploaded_file($fileTmp, $filedestination);
			}

			header("Location: ../assignwork.php?submit=success");
		}

		public function SubmitAssignment($validate,$Aid , $Course, $Short_Note, $FileRealName, $fileTmp, $FileDestination){
			$pdo = new Dbh();
			if($validate !== "Yes"){
				header("Location: ../submit.php?submit=notValidated");
				exit();
			}elseif ($validate == "Yes") {
				$sql = "INSERT INTO submit(Assign_Id, Username, Course, Short_Note, FileName) VALUES(?,?,?,?,?)";
				$stmt = $pdo->Connect()->prepare($sql);
				$stmt->execute([$Aid, $_SESSION['username'], $Course, $Short_Note, $FileRealName]);

				move_uploaded_file($fileTmp,$FileDestination);
			}

			header("Location: ../submit.php?submit=success");
		}


		public function TicketSubmitter($validate,$fileName, $fileTmp, $fileDestination , $subject, $Related, $Urgency, $Message){

			$pdo = new Dbh();
			if ($validate !== "Yes") {
				header("Location: ../subticket.php?submit=notValidated");
				exit();
			}elseif ($validate == "Yes") {
				// $array = array($validate , $subject, $Related, $Urgency, $Message);
				// print_r($array);

				if(empty($fileName)){
					$fileName = "Null";
				}else{
					move_uploaded_file($fileTmp, $fileDestination);
				}

				$active = 1;
				
				$sql = "INSERT INTO tickets(User_id, Subject, Related, Urgency, Message, is_active, FileName) VALUES(?,?,?,?,?,?,?)";
				$stmt = $pdo->Connect()->prepare($sql);
				$stmt->execute([$_SESSION['userid'], $subject, $Related, $Urgency, $Message, $active, $fileName]);

				header("Location: ../tickets.php?submit=success");
			}
		}

			public function TicketReplies($Tid, $Message, $Postion, $active){

				$pdo = new Dbh();
				$sql = "INSERT INTO ticket_replies(User_id, Ticket_id, Message, Position, is_active) VALUES(?,?,?,?,?)";
				$stmt = $pdo->Connect()->prepare($sql);
				$stmt->execute([$_SESSION['userid'], $Tid, $Message, $Postion, $active]);
			}

			public function TicketUpdater($active, $Tid){
				$pdo =  new Dbh();
				$sql = "UPDATE tickets SET is_active = ? WHERE id = ?";
				$stmt = $pdo->Connect()->prepare($sql);
				$stmt->execute([$active, $Tid]);
			}
		
	}

