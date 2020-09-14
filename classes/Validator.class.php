<?php
	
	Class Validator extends User{
		
		protected $Fullname;
		protected $Username;
		protected $Useremail;
		protected $Password;
		protected $Confirm;
		protected $Phone;
		protected $Dob;
		protected $State;
		protected $StateOrigin;

		public function SignupValues($Fullname, $Username, $useremail, $password, $confirm, $Phone, $dob, $state){

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

		public function Signupvalidate(){

		$states = array("abia","abuja","adamawa","akwa ibom" ,"anambra","bauchi","bayelsa","benue","borno","cross river","delta","ebonyi","edo","ekiti","enugu","gombe","imo","jigawa","kaduna","kano","katsina","kebbi","kogi","kwara","lagos","nasarawa","niger","ogun","ondo","osun","oyo","plateau","rivers","sokoto","taraba","yobe","zamfara");

		if (empty($this->Fullname) || empty($this->Username) || empty($this->Useremail) || empty($this->Password)  || empty($this->Confirm) || empty($this->Phone) || empty($this->Dob) || empty($this->State))
		 {
				header("Location: ../Signup.php?signup=empty&Fullname=$this->Fullname&Username=$this->Username&useremail=$this->Useremail&Phone=$this->Phone&StateOrigin=$this->StateOrigin");
				exit();
		}elseif (!preg_match("/^[ a-zA-Z]*$/", $this->Fullname)) {
			header("Location: ../Signup.php?signup=nameerror&Fullname=$this->Fullname&Username=$this->Username&useremail=$this->Useremail&Phone=$this->Phone&StateOrigin=$this->StateOrigin");
			exit();
		}elseif (!preg_match("/^[a-zA-Z0-9]*$/", $this->Username)){
			header("Location: ../Signup.php?signup=usernameinvalid&Fullname=$this->Fullname&Username=$this->Username&useremail=$this->Useremail&Phone=$this->Phone&StateOrigin=$this->StateOrigin");
			exit();
		}elseif (!preg_match("/^[0-9]*$/", $this->Phone)) {
			header("Location: ../Signup.php?signup=invalidphone&Fullname=$this->Fullname&Username=$this->Username&useremail=$this->Useremail&Phone=$this->Phone&StateOrigin=$this->StateOrigin");
			exit();
		}elseif (!filter_var($this->Useremail, FILTER_VALIDATE_EMAIL)) {
			header("Location: ../Signup.php?signup=invalidemail&Fullname=$this->Fullname&Username=$this->Username&useremail=$this->Useremail&Phone=$this->Phone&StateOrigin=$this->StateOrigin");
			exit();
		}elseif (strlen($this->Password) < 8 || strlen($this->Password) > 21) {
			header("Location: ../Signup.php?signup=lesspass&Fullname=$this->Fullname&Username=$this->Username&useremail=$this->Useremail&Phone=$this->Phone&StateOrigin=$this->StateOrigin");
			exit();
		}elseif (!preg_match('/[^a-zA-Z0-9]/', $this->Password)) {
			header("Location: ../Signup.php?signup=passnochar&Fullname=$this->Fullname&Username=$this->Username&useremail=$this->Useremail&Phone=$this->Phone&StateOrigin=$this->StateOrigin");
			exit();
		}elseif ($this->Password !== $this->Confirm) {
			header("Location: ../Signup.php?signup=passwordnotmatch&Fullname=$this->Fullname&Username=$this->Username&useremail=$this->Useremail&Phone=$this->Phone&StateOrigin=$this->StateOrigin");
			exit();
		}elseif (!in_array($this->State, $states)) {
			header("Location: ../Signup.php?signup=invalidstate&Fullname=$this->Fullname&Username=$this->Username&useremail=$this->Useremail&Phone=$this->Phone&StateOrigin=$this->StateOrigin");
			exit();
		}else{
			$date = getdate();
			$year = $date['year'];
			$year_valid = $year - 18;
			$input_date = explode("-", $_POST['dob']);
			$input_year = $input_date[0];

			if ($input_year <=! $year_valid) {
				header("Location: ../Signup.php?signup=invaliddate&Fullname=$this->Fullname&Username=$this->Username&useremail=$this->Useremail&Phone=$this->Phone&StateOrigin=$this->StateOrigin");
				exit();
			}else{

				$Usertocheck = $this->GetUsernames($this->Username);

				if (count($Usertocheck) > 0) {
				header("Location: ../Signup.php?signup=usernameused&Fullname=$this->Fullname&Username=$this->Username&useremail=$this->Useremail&Phone=$this->Phone&StateOrigin=$this->StateOrigin");
				exit();
				}else{
					$emailtocheck = $this->GetEmails($this->Useremail);

					if (count($emailtocheck) > 0) {
						header("Location: ../Signup.php?signup=emailused&Fullname=$this->Fullname&Username=$this->Username&useremail=$this->Useremail&Phone=$this->Phone&StateOrigin=$this->StateOrigin");
						exit();
					}else{
						$phonetocheck = $this->GetPhones($this->Phone);

						if (count($phonetocheck) > 0) {
							header("Location: ../Signup.php?signup=phoneused&Fullname=$this->Fullname&Username=$this->Username&useremail=$this->Useremail&Phone=$this->Phone&StateOrigin=$this->StateOrigin");
							exit();
						}else{
							$validate = "Yes";
						}
					}
				}
			}
		}
		
		return $validate;
	}




	public function LoginValidator($Userinfo, $Password){

		if (empty($Userinfo) || empty($Password)) {
			header("Location: ../login.php?login=emtpy&userinfo=$userinfo");
			exit();
		}elseif (!preg_match("/^[a-zA-Z0-9]*$/", $Userinfo) AND !filter_var($Userinfo, FILTER_VALIDATE_EMAIL)) {
			header("Location: ../login.php?login=userinfoinvalid&userinfo=$userinfo");
			exit();
		}

		$Users = $this->UsersToLogin($Userinfo);
		$UsersCount = count($Users);

		if ($UsersCount > 0) {
			foreach ($Users as $User) {
				$passcheck = password_verify($Password, $User['Password']);

				if ($passcheck == false) {
					header("Location: ../login.php?login=invalidpass&userinfo=$userinfo");
					exit();
				}elseif ($passcheck == true) {
					$Validate = "Yes";
				}
			}
		}else{
			header("Location: ../login.php?login=Usernotexist&userinfo=$userinfo");
			exit();
		}

		return $Validate;

	}




	public function MyAccountValidator($Fullname, $Dob, $State){

	$name = $Fullname;
    $dob = $Dob;
    $inputstate = $State;
    $userid = $_SESSION['userid'];
    $useremail = $_SESSION['email'];
    $StateOrigin = str_replace(" ", " ", $inputstate);
    $state = strtolower($StateOrigin);
    $states = array("abia","abuja","adamawa","akwa ibom" ,"anambra","bauchi","bayelsa","benue","borno","cross river","delta","ebonyi","edo","ekiti","enugu","gombe","imo","jigawa","kaduna","kano","katsina","kebbi","kogi","kwara","lagos","nasarawa","niger","ogun","ondo","osun","oyo","plateau","rivers","sokoto","taraba","yobe","zamfara");

    if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
      header("Location: ../accountdetails.php?update=invalidchar");
      exit();
    }elseif (!in_array($state, $states)) {
     header("Location: ../accountdetails.php?update=invalidstate");
      exit();
    }else{
      $date = getdate();
      $year = $date['year'];
      $year_valid = $year - 18;
      $input_date = explode("-", $dob);
      $input_year = $input_date[0];


      if ($input_year > $year_valid) {

        header("Location: ../accountdetails.php?update=dateinvalid");
        exit();
    }else{
    	$ProfileStats = $this->GetUpdateProfileStat();

    	foreach($ProfileStats as $ProfileStat){

    		$profile = $ProfileStat['profilestatus'];
    	}

    	if ($profile == 1) {
    		header("Location: ../accountdetails.php?update=donebefore");
    		exit();
    	}elseif($profile == 0){
    		$validate = "Yes";
    	}

    }
    }

    	return $validate;

	}



	Public function ProfileImgStat($fileName, $fileRealExt, $fileSize){

    $allowed = array("jpg","png","jpeg");
    

    if (empty($fileName)) {
    	header("Location: ../accountdetails.php?imgupdate=nofile");
    	exit();
    }elseif (!in_array($fileRealExt,$allowed)) {
    	header("Location: ../accountdetails.php?imgupdate=notallowed");
    	exit();
    }elseif ($fileSize > 5000000) {
    	header("Location: ../accountdetails.php?imgupdate=filetoobig");
    	exit();
    }else{
    	$validate = "Yes";
    }

    return $validate;
	}



	public function CourseRegValidator($course_1, $course_2, $course_3, $course_4){

		$courses = array("business studies","project management","business administration","transport management");
		$DbCourses = $course_1.",".$course_2.",".$course_3.",".$course_4;

		if (empty($course_1) || empty($course_2) || empty($course_3) || empty($course_4)) {
			header("Location: ../course_register.php?register=empty");
			exit();
		}elseif (!preg_match("/^[a-zA-Z ]*$/", $course_1) || !preg_match("/^[a-zA-Z ]*$/", $course_2) || !preg_match("/^[a-zA-Z ]*$/", $course_3) || !preg_match("/^[a-zA-Z ]*$/", $course_4)) {
			header("Location: ../course_register.php?register=invalidchar");
			exit();
		}elseif (!in_array($course_1, $courses)) {
			header("Location: ../course_register.php?register=invalidcourse1");
			exit();
		}elseif (!in_array($course_2, $courses)) {
			header("Location: ../course_register.php?register=invalidcourse2");
			exit();
		}elseif (!in_array($course_3, $courses)) {
			header("Location: ../course_register.php?register=invalidcourse3");
			exit();
		}elseif (!in_array($course_4, $courses)) {
			header("Location: ../course_register.php?register=invalidcourse4");
			exit();
		}else{

			$Courses = $this->GetCourses();
			$CoursesCount = count($Courses);

			 if ($CoursesCount > 0 ) {
			 	header("Location: ../course_register.php?register=donebefore");
			 		exit();
			 }else{

			 	$Validate = "Yes";
			 }
		}

		 $result = array($Validate, $DbCourses);
		 return $result;
	}


	public function AssignWorkValidator($course, $lecturer, $submission, $title, $filename, $fileDataName, $filesize){

		if (empty($course) || empty($lecturer) || empty($submission) || empty($title) || empty($filename) || empty($fileDataName) ) {
			header("Location: ../assignwork.php?submit=empty");
			exit();
		}elseif (!preg_match("/^[a-zA-Z ]*$/", $lecturer) || !preg_match("/^[a-zA-Z0-9 ]*$/", $filename)) {
			header("Location: ../assignwork.php?submit=invalidchar");
			exit();
		}elseif ($filesize > 50000000) {
			header("Location: ../assignwork.php?submit=filetoobig");
			exit();
		}else{
			$validate = "Yes";
		}

		return $validate;
	}

	public function AssignmentValidator($Aid, $Lecturer, $Course, $fileName, $fileSize, $fileError){

		if(!isset($_POST['submit'])){
			header("Location: ../submit.php?submit=submit");
			exit();
		}elseif (empty($Aid) || empty($Lecturer) || empty($Course) ) {
			header("Location: ../submit.php?submit=Empty");
			exit();
		}elseif (!preg_match("/^[0-9]*$/", $Aid)) {
			header("Location: ../submit.php?submit=invalidAid");
			exit();
		}elseif(!preg_match("/^[a-zA-Z .,]*$/", $Lecturer)){
			header("Location: ../submit.php?submit=InvalidLec");
			exit();
		}elseif (!preg_match("/^[a-zA-Z ]*$/", $Course)) {
			header("Location: ../submit.php?submit=InvalidCourse");
			exit();
		}elseif (empty($fileName)) {
			header("Location: ../submit.php?submit=InvalidFileName");
			exit();
		}elseif ($fileSize > 30000000) {
			header("Location: ../submit.php?submit=filetooBig");
			exit();
		}elseif ($fileError == 1) {
			header("Location: ../submit.php?submit=error");
			exit();
		}else {
			$GetAssignment = new Userview();
			$validIds = $GetAssignment->GetAssignmentsId($Aid);

			foreach($validIds as $validId){
				if(!in_array($Aid, $validId)){
					header("Location: ../submit.php?submit=AidNotExists");
					exit();
				}else{
					$GetSubmittedAssign = $this->GetSubmittedAssignment($Aid);
					$count = count($GetSubmittedAssign);

					if ($count > 0) {
						header("Location: ../submit.php?submit=submitted before");
						exit();
					}else{
						$validate = "Yes";
					}
				}
			}	
		}

		 return $validate;
	}

	public function TicketValidator($subject, $Message){
		if(!isset($_POST['submit'])){
			header("Location: ../Subticket.php?submit=submit");
			exit();
		}elseif(empty($subject)){
			header("Location: ../Subticket.php?submit=emptysubject");
			exit();
		}elseif (empty($Message)) {
			header("Location: ../Subticket.php?submit=emptymessage");
			exit();
		}else{
			$validate = "Yes";
		}

		return $validate;
	}
}
