<?php
/**
 * Intreface DAO
 *
 * @author: cgajardo
 * @date: 2012-04-20 00:47
 */
interface UsersDAO{
	
	/**
	* Returns user data by id column
	*/
	public function load($id);
	
	
	/**
	 * Returns a list of users participating in one repository
	 * @param int $id
	 */
	public function getByRepositoryId($id);
	
	/**
	 * Returns user data by email address
	 * @param String $email
	 */
	public function queryByEmail($email);
	
}
?>