<?php
/**
 * Intreface DAO
 *
 * @author: cgajardo
 * @date: 2012-05-13 17:07
 */
interface ChallengesDAO{
	
	/**
	 * Returns a Challenge for the given user in the given repository
	 *
	 * @param int $repository_id
	 * @param int $user_id
	 * @return Challenge
	 */
	public function getChallenges($repository_id, $user_id);
	
}
?>