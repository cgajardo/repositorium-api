<?php
class Users{
	
	public static function add(){
		//TODO: hacer!
	}

	public static function login($username){
		if(!isset($_POST['password'])){
			header('HTTP/1.1 401 Unauthorized');
			exit(0);
		}
		
		$password = $_POST['password'];
		//TODO: Finnish!
	}
	
	public static function load($username){
		//TODO: do!
	}
	
	public static function update($username){
		//TODO: do!
	}
	
	public static function loadRepositories($username){
		//TODO: do!
	}

}
?>