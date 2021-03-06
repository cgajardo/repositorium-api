<?php
class Users{
	
	public static function add(){
		// TODO: check email is unique!!!
		// TODO: RepositoriesUser and CriteriasUser MASSCREATE
		$User = new User();
		//check for minimum set of data
		if(!isset($_POST['name']) or !isset($_POST['email']) or !isset($_POST['password'])){
			header('HTTP/1.1 488 Incomplete request');
			$Error = new Error();
			$Error->status = "488 Incomplete request";
			$Error->message = "Please provide email, name and password";
			return $Error->toArray();
		}
		
		$User->email = $_POST['email'];
		$User->name = $_POST['name'];
		$User->lastname = $_POST['lastname'];
		
		$id = DAOFactory::getUsersDAO()->add($User, $_POST['password']);
		$newUser = DAOFactory::getUsersDAO()->load($id);
		return $newUser->toArray();
	}

	public static function login(){
		
		if(!isset($_POST['password'])){
			header('HTTP/1.1 401 Unauthorized');
			$Error = new Error();
			$Error->status = "401 Unauthorized";
			$Error->message = "Please provide an email and password";
			return $Error->toArray();
		}
		
		$password = $_POST['password'];
		$email = $_POST['email'];
		$User = DAOFactory::getUsersDAO()->queryByEmail($email);
		
		/**
		 * if passwords match, then add user to session
		 * otherwise return error message
		 */
		
		$checkPassword = array( 'self', 'checkPassword' );
		
		if(call_user_func( $checkPassword, $User->id, $password)) {
			getSession()->set('user', $User);
			return $User->toArray();
			
		}else{
			header('HTTP/1.1 401 Unauthorized');
			$Error = new Error();
			$Error->status = "401 Unauthorized";
			$Error->message = "Incorrect email or password";
			return $Error->toArray(); 
			
		}
		
	}
	
	public static function load($email){
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
					"message"=>"User with email ".$email
						." was not found. If you want to create an user, try doin a POST to /users");
		}
		
		if(isset($_PUT['name']))
			$user->name = $_PUT['name'];

		if(isset($_PUT['lastname']))
			$user->lastname = $_PUT['lastname'];
			
		if(isset($_PUT['new_password']) && isset($_PUT['password'])){
			
			$checkPassword = array( 'self', 'checkPassword' );
			if(call_user_func( $checkPassword, $user->id, $password)){
				$salt = DAOFactory::getUsersDAO()->getUserSalt($user->id);
				$newPassword = sha1($_PUT['new_password'].$salt);
				DAOFactory::getUsersDAO()->updatePassword($user->id,$newPassword);
				
			}else{
				header('HTTP/1.1 401 Unauthorized');
				$Error = new Error();
				$Error->status = "401 Unauthorized";
				$Error->message = "Incorrect Password";
				return $Error->toArray();
			}
		}
		
		//finally we update User data and the user in session
		DAOFactory::getUsersDAO()->update($user);
		getSession()->set('user', $user);
	}
	
	public static function loadRepositories($email){
		return DAOFactory::getRepositoriesDAO()->queryForUser($email);
	}
	
	
	public static function checkPassword($user_id, $password){
		$originalPassword = DAOFactory::getUsersDAO()->getUserPassword($user_id);
		$salt = DAOFactory::getUsersDAO()->getUserSalt($user_id);
		$calculatedPassword = sha1($password.$salt);
		// if passwords match, return true
		if(strcmp($calculatedPassword,$originalPassword) == 0)
			return true;
		//else
		return false;
	}

}
?>