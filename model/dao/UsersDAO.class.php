<?php
/**
 * Intreface DAO
 *
 * @author: cgajardo
 * @date: 2012-04-20 00:47
 */
interface UsersDAO{
	
	/**
	* Returns an User with ID = $id
	*/
	public function load($id);
	
	
	/**
	 * Return a list of users participating in one repository
	 *  
	 * @param int $id
	 */
	public function getByRepositoryId($id);
	
}
?>