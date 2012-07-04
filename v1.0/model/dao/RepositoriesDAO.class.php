<?php
/**
 * Intreface DAO
 *
 * @author: cgajardo
 * @date: 2012-04-20 00:47
 */
interface RepositoriesDAO{
	
	/**
	 * Returns number of criterion in a repository
	 * @param int $repository_id
	 * @return int
	 */
	public function getNumberOfCriterion($repository_id);
	
	/**
	 * Returns the number of documents in a repository
	 * @param int $repository_id
	 * @return int
	 */
	public function getNumberOfDocuments($repository_id);
	
	/**
	 * Returns the number of users in a repository
	 * @param int $repository_id
	 * @return int
	 */
	public function getNumberOfUsers($repository_id);
	
	/**
	 * Returns the size of a dicument pack for a given repository
	 * @param int $repository_id
	 * @return int
	 */
	public function getPackSize($repository_id);
	
	/**
	 * Returns the download cost for a given repository
	 * @param int $repository_id
	 * @return int
	 */
	public function getDownloadCost($repository_id);
	
	/**
	* Returns a list of repositories
	* @return Repositories[]
	*/
	public function queryAll();
	
	/**
	 * Returns the repository with param as ID
	 * @param int $repository_id 
	 */
	public function load($repository_id);
	
}
?>