<?php
/**
 * Intreface DAO
 *
 * @author: cgajardo
 * @date: 2012-04-20 00:47
 */
interface DocumentsDAO{
	
	/**
	 * Add a new document
	 * 
	 * @param Document $Document
	 * @param int $repo_id
	 */
	public function insert($Document, $repo_id);
	
	/**
	 * Returns data for document with ID $document_id
	 * 
	 * @param int $document_id
	 */
	public function load($document_id);
	
	/**
	 * Returns a random list o document matching the search query in _filters
	 * 
	 * @param int $repository_id
	 * @param string $filters
	 * @param int $limit
	 */
	public function search($repository_id, $filters, $limit);

	/**
	 * Returns a random document from referenced repository
	 * 
	 * @param int $repository_id
	 */
	public function getRandom($repository_id);
	
}
?>