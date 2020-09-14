<?php

	class User extends Dbh{


		public function GetUsernames($Username){

			$sql = "SELECT * FROM users WHERE Username = ?";
			$stmt = $this->Connect()->prepare($sql);
			$stmt->execute([$Username]);
			$usernames = $stmt->fetchAll();
			return $usernames; 
		}

		public function GetEmails($email){

			$sql = "SELECT * FROM users WHERE Email = ?";
			$stmt = $this->Connect()->prepare($sql);
			$stmt->execute([$email]);
			$emails = $stmt->fetchAll();
			return $emails; 
		}

		public function GetPhones($phones){

			$sql = "SELECT * FROM users WHERE Phone = ?";
			$stmt = $this->Connect()->prepare($sql);
			$stmt->execute([$phones]);
			$Phones = $stmt->fetchAll();
			return $Phones; 
		}

		public  function GetRegNumbers(){

			$sql = "SELECT * FROM user_profile";
			$stmt = $this->Connect()->query($sql);
			$Regnos = $stmt->fetchAll();
			return $Regnos; 
		}


		public function GetUsers($Username, $Email){

			$sql = "SELECT * FROM users WHERE Username = ? AND Email = ?";
			$stmt = $this->Connect()->prepare($sql);
			$stmt->execute([$Username, $Email]);
			$Users = $stmt->fetchAll();
			return $Users; 
		}

		public function UsersToLogin($userinfo){

			$sql = "SELECT * FROM users WHERE Username = ? || Email = ?";
			$stmt = $this->Connect()->prepare($sql);
			$stmt->execute([$userinfo, $userinfo]);
			$Users = $stmt->fetchAll();

			return $Users;
		}

		public function GetUserRegNoId($userid){
			$sql = "SELECT * FROM user_profile WHERE user_id = ?";
			$stmt =  $this->Connect()->prepare($sql);
			$stmt->execute([$userid]);
			$Regnos = $stmt->fetchAll();

			return $Regnos;
		}

		public function GetUpdateProfileStat(){
			$sql = "SELECT * FROM user_profile WHERE user_id = ?";
			$stmt = $this->Connect()->prepare($sql);
			$stmt->execute([$_SESSION['userid']]);
			$ProfileStat = $stmt->fetchAll();

			return $ProfileStat;
		}

		public function GetCourses(){
			$sql = "SELECT * FROM courses WHERE user_id = ?";
			$stmt = $this->Connect()->prepare($sql);
			$stmt->execute([$_SESSION['userid']]);

			$courses = $stmt->fetchAll();
			return $courses;
		}

		public function GetAssignments($Courses){
			$sql = "SELECT * FROM assign_given WHERE Course = ?";
			$stmt = $this->Connect()->prepare($sql);
			$stmt->execute([$Courses]);
			$Assignments = $stmt->fetchAll();
			
			return $Assignments;
		}

		public function GetSubmittedAssignment($Aid){
			$sql = "SELECT * FROM submit WHERE Assign_Id = ? AND Username = ?";
			$stmt = $this->Connect()->prepare($sql);
			$stmt->execute([$Aid, $_SESSION['username']]);
			$Results = $stmt->fetchAll();

			return $Results;
		}

		public function GetSubmittedAssignmentUser(){
			$sql = "SELECT * FROM submit WHERE  Username = ?";
			$stmt = $this->Connect()->prepare($sql);
			$stmt->execute([$_SESSION['username']]);
			$Results = $stmt->fetchAll();

			return $Results;
		}

		public function GetTickets(){
			$sql = "SELECT * FROM tickets WHERE User_id = ?";
			$stmt = $this->Connect()->prepare($sql);
			$stmt->execute([$_SESSION['userid']]);
			$tickets = $stmt->fetchAll();

			return $tickets;
		}

		public function GetActiveTickets(){
			$sql = "SELECT * FROM tickets WHERE User_id = ? AND is_active = 1 || is_active = 2";
			$stmt = $this->Connect()->prepare($sql);
			$stmt->execute([$_SESSION['userid']]);
			$tickets = $stmt->fetchAll();

			return $tickets;
		}

		public function GetResolvedTickets(){
			$sql = "SELECT * FROM tickets WHERE User_id = ? AND is_active = 0";
			$stmt = $this->Connect()->prepare($sql);
			$stmt->execute([$_SESSION['userid']]);
			$tickets = $stmt->fetchAll();

			return $tickets;
		}

		public function GetSearchTickets($search){
			$sql = "SELECT * FROM tickets WHERE Subject LIKE  '%$search%' || Related LIKE '%$search%' || Urgency LIKE '%$search%' || Message LIKE '%$search%' AND user_id = ? ";
			$stmt = $this->Connect()->prepare($sql);
			$stmt->execute([ $_SESSION['userid']]);
			$tickets = $stmt->fetchAll();
			
			return $tickets;
		}

		public function GetTicketsId($Tid){
			$sql = "SELECT * FROM tickets WHERE id = ? AND user_id = ?";
			$stmt = $this->Connect()->prepare($sql);
			$stmt->execute([$Tid , $_SESSION['userid']]);
			$tickets = $stmt->fetchAll();

			return $tickets;
		}

		
		
	}