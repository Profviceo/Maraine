<?php

	Class Dbh{

		private $Host = 'localhost';
		private $User = 'root';
		private $Pwd = '';
		private $DbName = 'maraine';

		public function Connect(){

			$dsn = "mysql:host=".$this->Host.";dbname=".$this->DbName;
			$pdo = new PDO($dsn, $this->User , $this->Pwd);
			$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_ASSOC);

			return $pdo;
		}
	}