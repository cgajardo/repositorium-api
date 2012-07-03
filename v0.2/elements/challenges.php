<?php
class Challenges{
	
	/**
	 * @param int $repo_id
	 */
	public function submit($repo_id){
		
		$User = getSession()->get('user');
		//there's no user in session
		if($User == null)
			return returnError('401 Unauthorized','User must be logged in');
		
		$challenge_id = $_POST['id'];
		$answer = $_POST['id'];
		
		$idChallenge = $_POST['id'];
		$challengeData = getSession()->get($idChallenge);
		$realIdChallenge = $challengeData['idcriteria'];
		unset($challengeData['idcriteria']);
		foreach ($challengeData as $key => $docID){
			$userAnswer = $_POST[$key];
			if($userAnswer=='a'){
				DAOFactory::getChallengesDAO()->updateVoteA($repo_id, $realIdChallenge, $docID, $User->id);
			}elseif($userAnswer=='b'){
				DAOFactory::getChallengesDAO()->updateVoteB($repo_id, $realIdChallengem, $docID, $User->id);
			}else{
				return returnError('409 Conflict','You must provide an answer for document with id '.$key);
			}
		}
		//usually after a search
		$query = getSession()->get("search_query");
		if($query!=null){
			//try to perform the querry again
			Repositories::search($repo_id, $query);
			
		}
	}
	
	
	public static function get($repo_id){
		$User = getSession()->get('user');
		//there's no user in session
		if($User == null){
			return returnError('401 Unauthorized','User must be logged in');
		}
			
		$challenges = DAOFactory::getChallengesDAO()->getChallenges($repo_id,$User->id);
			
		//return a challenge for this user
		return $challenges;
	}
}