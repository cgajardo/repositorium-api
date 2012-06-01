<?php
/**
 * Intreface DAO
 *
 * @author: cgajardo
 * @date: 2012-04-20 00:47
 */
interface DocumentsDAO{
	
	/**
	 * Returns a random list o document matching the search query in _filters
	 * 
	 * @param int $repository_id
	 * @param string $filters
	 * @param int $limit
	 */
	public function search($repository_id, $filters, $limit);	
	
}
?>