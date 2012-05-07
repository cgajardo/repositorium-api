<?php
class Users{
	
	public static function add(){
		//TODO: hacer!
	}

	public static function login(){
		
		if(!isset($_GET['password'])){
			header('HTTP/1.1 401 Unauthorized');
			$Error = new Error();
			$Error->status = "401 Unauthorized";
			$Error->message = "Please provide an username and password";
			return $Error->toArray();
		}
		
		$password = $_GET['password'];
		$email = $_GET['email'];
		//TODO: Si el password coincide, lo agrego a la session!
		$User = DAOFactory::getUsersDAO()->queryByEmail($email);
		getSession()->set('user', $User);
		
		return $User->toArray();
	}
	
	public static function load($email){
		//TODO: aplicar esto nivel de la api
		header('Content-type: application/json');
		$user = DAOFactory::getUsersDAO()->queryByEmail($email);
		return $user;
	}
	
	public static function update($email){
		//trying to bypass PHP missing support for PUT and DELETE
		$_PUT = array();
		parse_str(file_get_contents('php://input'), $_PUT);
		
		$user = DAOFactory::getUsersDAO()->queryByEmail($email);
		if($user==null){
			header('HTTP/1.1 400 Bad Request');
			return array(
					"status"=>"400 Bad Request", 
					"message"=>"user with email ".$email
						." was not found. If you want to create an user, try doin a POST to /users");
		}
		
		if(isset($_PUT['name'])){
			$user->name = $_PUT['name'];
			//header('HTTP/1.1 418 I\'m a teapot');		
		}
		if(isset($_PUT['lastname'])){
			$user->lastname = $_PUT['lastname'];
		}
		if(isset($_PUT['new_password']) && isset($_PUT['password'])){
			//TODO: Si el password coincide, cambio el password
			DAOFactory::getUsersDAO()->updatePassword($email, $_PUT['new_password']);
		}
		
	}
	
	public static function loadRepositories($username){
		//TODO: do!
	}

}
?>