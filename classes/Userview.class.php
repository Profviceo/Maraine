<?php

	Class Userview extends User{


		public function LoginBot($validate, $userinfo){

			if ($validate !== "Yes") {
				header("Location: ../Login.php?Login=notvalidated");
				exit();
			}elseif ($validate == "Yes") {
				$Users = $this->UsersToLogin($userinfo);
				foreach ($Users as $User) {
					$_SESSION['userid'] = $User['id'];
					$_SESSION['name'] = $User['FullName'];
					$_SESSION['username'] = strtolower($User['Username']);
					$_SESSION['email'] = $User['Email'];
					$_SESSION['dob'] = $User['DOB'];
					$_SESSION['phone'] = $User['Phone'];
					$_SESSION['state'] = $User['State'];
				}

				$Regnos = $this->GetUserRegNoId($_SESSION['userid']);
				
				foreach ($Regnos as $Regno) {
					$_SESSION['regno'] = $Regno['Reg_No'];
				}
			}

			if ($_SESSION['username'] == "admin") {
			header("Location: ../admin.php");
			exit();
		}
			 header("Location: ../index.php?login=success");
		 }

		 public function Assignments(){

			$Courses = $this->GetCourses();
			foreach($Courses as $Course){
				$DBcourse = $Course['courses'];
				$exploded = explode(",", $DBcourse);
			}
			return $exploded;
		 }

		 public function GetAssignmentsId($aid){
			$sql = "SELECT * FROM assign_given WHERE id = ?";
			$stmt = $this->Connect()->prepare($sql);
			$stmt->execute([$aid]);
			$Assignments = $stmt->fetchAll();
			
			return $Assignments;
		}

		public function GetAssignmentsLecturer($lecturer){
			$sql = "SELECT * FROM assign_given WHERE Lecturer = ?";
			$stmt = $this->Connect()->prepare($sql);
			$stmt->execute([$lecturer]);
			$Assignments = $stmt->fetchAll();
			
			return $Assignments;
		}

		public function GetAssignmentsCourse($Course){
			$sql = "SELECT * FROM assign_given WHERE Course = ?";
			$stmt = $this->Connect()->prepare($sql);
			$stmt->execute([$Course]);
			$Assignments = $stmt->fetchAll();
			
			return $Assignments;
		}

		public function GetSubmittedAssignmentSearch($search){
			$sql = "SELECT * FROM submit WHERE Assign_Id LIKE '%$search%' || Course LIKE '%$search%' || Short_Note LIKE '%$search%' || DateSubmitted LIKE '%$search%' AND Username = ?";
			$stmt = $this->Connect()->prepare($sql);
			$stmt->execute([$_SESSION['username']]);
			$results = $stmt->fetchAll();

			return $results;
		}

		public function GetAllAssignmentSearch($search){
			$sql = "SELECT * FROM assign_given WHERE id LIKE '%$search%' || Course LIKE '%$search%' || Lecturer LIKE '%$search%' || Submissiondate LIKE '%$search%' || assign_title LIKE '%$search%'";
			$stmt = $this->Connect()->prepare($sql);
			$stmt->execute([$search]);
			$results = $stmt->fetchAll();

			return $results;
		}

		public function GetTicketReply($Tid){
			$sql = "SELECT * FROM ticket_replies WHERE user_id = ?  AND Ticket_id = ?";
			$stmt = $this->Connect()->prepare($sql);
			$stmt->execute([$_SESSION['userid'], $Tid]);
			$tickets = $stmt->fetchAll();

			return $tickets;
		}


	}