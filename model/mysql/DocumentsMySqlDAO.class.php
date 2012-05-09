<?php
/**
 * 
 * @author: cgajardo
 * @date: 2012-05-08 16:32
 */
class DocumentsMySqlDAO implements DocumentsDAO{

/** Public functions **/
	



/** Private functions **/
	
	/**
	 * Read row
	 *
	 * @return Repository
	 */
	protected function readRow($row){
		$document = new Document();
		
		$document->title = $row['title'];
		$document->content = $row['content']; 
		$document->created = $row['created'];
		$document->author = $row['user_id'];
		//TODO: retrieve tags and files
		$document->tags = null;
		$document->files = null;

		return $document;
	}
	
	protected function getList($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$ret[$i] = $this->readRow($tab[$i]);
		}
		return $ret;
	}
	
	/**
	 * Get row
	 *
	 * @return BadgesMySql 
	 */
	protected function getRow($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		if(count($tab)==0){
			return null;
		}
		return $this->readRow($tab[0]);		
	}
	
	/**
	 * Execute sql query
	 */
	protected function execute($sqlQuery){
		return QueryExecutor::execute($sqlQuery);
	}
	
		
	/**
	 * Execute sql query
	 */
	protected function executeUpdate($sqlQuery){
		return QueryExecutor::executeUpdate($sqlQuery);
	}

	/**
	 * Query for one row and one column
	 */
	protected function querySingleResult($sqlQuery){
		return QueryExecutor::queryForString($sqlQuery);
	}

	/**
	 * Insert row to table
	 */
	protected function executeInsert($sqlQuery){
		return QueryExecutor::executeInsert($sqlQuery);
	}
}
?>