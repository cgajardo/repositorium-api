<?php
/**
 * Intreface DAO
 *
 * @author: cgajardo
 * @date: 2012-04-20 00:47
 */
interface RepositoriesDAO{
	
	/**
	 * Returns the size of a dicument pack for a given repository
	 * @param int $repository_id
	 */
	public function getPackSize($repository_id);
	
	/**
	 * Returns the download cost for a given repository
	 * @param int $repository_id
	 */
	public function getDownloadCost($repository_id);
	
	/**
	* Returns a list of repositories
	*
	*/
	public function queryAll();
	
	/**
	 * Returns the repository with param as ID
	 * @param int $repository_id 
	 */
	public function load($repository_id);
	
}
?>