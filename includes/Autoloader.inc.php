<?php 

	spl_autoload_register('Autoloader');

	function Autoloader($classname){

		$Ext = ".class.php";
		$url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		if (preg_match("/includes/", $url)) {
			$path = "../classes/";
		}elseif(!preg_match("/includes/", $url)){
			$path = "classes/";
		}

		$filepath = $path.$classname.$Ext;
		require_once $filepath;
	}