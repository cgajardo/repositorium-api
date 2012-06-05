<?php
class Challenges{
	
	/**
	 * 
	 * @param unknown_type $repo_id
	 */
	public function submit($repo_id){
		
		$User = getSession()->get('user');
		//there's no user in session
		if($User == null)
			return returnError('401 Unauthorized','User must be logged in');
		
		$challenge_id = $_POST['id'];
		$answer = $_POST['id'];
		//TODO: save this challenge
		
		$query = getSession()->get("search_query");
		
		//try to perform the querry again
		Repositories::search($repo_id, $query);
	}
}