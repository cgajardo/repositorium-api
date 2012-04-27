<?php
/**
 * Intreface DAO
 *
 * @author: cgajardo
 * @date: 2012-04-20 00:47
 */
interface RepositoriesDAO{
	
	/**
	* Returns a list of repositories
	*
	*/
	public function queryAll();
	
	/**
	 * Returns the repository with param as ID 
	 */
	public function load($id);
	
}
?>