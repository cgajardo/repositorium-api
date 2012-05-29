<?php
/**
 * Intreface DAO
 *
 * @author: cgajardo
 * @date: 2012-04-20 00:47
 */
interface UsersDAO{
	
	/** Substract points from user in a repository
	 * 
	 * @param int $repo_id
	 * @param int $user_id
	 */
	public function substractPoints($repo_id, $user_id);
	
	/**
	* Returns user data by id column
	* @param int $user_id
	*/
	public function load($user_id);
	
	
	/**
	 * Returns a list of users participating in one repository
	 * @param int $repo_id
	 */
	public function getByRepositoryId($repo_id);
	
	/**
	 * Returns user data by email address
	 * @param String $email
	 */
	public function queryByEmail($email);
	
}
?>