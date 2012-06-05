<?php
/**
 * Intreface DAO
 *
 * @author: cgajardo
 * @date: 2012-04-20 00:47
 */
interface UsersDAO{
	
	/** 
	 * Substract points from user in a repository
	 * 
	 * @param int $repo_id
	 * @param int $user_id
	 */
	public function substractPoints($repo_id, $user_id);
	
	
	/**
	 * Add a new user to the system
	 * 
	 * @param User $user
	 * @param String $password
	 */
	public function add($user, $password);
	
	
	/**
	 * Update user data
	 * 
	 * @param User $user
	 */
	public function update($user);
	
	
	/**
	 * Returns User salt by user_id
	 * 
	 * @param int $user_id
	 */
	public function getUserSalt($user_id);
	
	
	/**
	 * Returns password by user_id
	 *
	 * @param int $user_id
	 */
	public function getUserPassword($user_id);
	
	
	/**
	 * Returns points gained by User (user_id) in a Repository (reposiotory_id)
	 * 
	 * @param int $user_id
	 * @param int $repository_id
	 */
	public function getPointsInRepo($user_id, $repository_id);
	
	/**
	 * Update User (user_id) password. Password must be encrypted previously
	 * NOTE this function does not add SALT to password.
	 * 
	 * @param int $user_id
	 * @param String $password
	 */
	public function updatePassword($user_id, $password);
	
	
	/**
	 * Returns user data by id column
	 * @param int $user_id
	 */
	public function load($user_id);
	
	
	/**
	 * Returns a list of users participating in one repository
	 * 
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