<?php
/**
 * 
 * @author: cgajardo
 * @date: 2012-05-08 16:32
 */
class DocumentsMySqlDAO implements DocumentsDAO{

/** Public functions **/
	
	public function getRandom($repository_id){
		$sql = "SELECT d.id, d.title, d.content, d.created, d.user_id ".
				"FROM documents as d, tags as t ".
				"WHERE d.id = t.document_id AND repository_id = ? ORDER BY RAND() LIMIT 1";
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($repository_id);
		
		return $this->getRow($sqlQuery);
	}
	
	public function queryForChallenge($criteria_id, $total){
		$sql = "SELECT d.id, d.title, d.content, d.created, d.user_id ".
				"FROM documents AS d, criterias_documents AS cd ".
				"WHERE cd.document_id = d.id AND cd.criteria_id = ? ".
				"ORDER BY RAND() ".
				"LIMIT ?";
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($criteria_id);
		$sqlQuery->setNumber($total);
		
		return $this->getList($sqlQuery);
		
	}
	
	public function search($repository_id, $filters, $limit){
		$sql = "SELECT d.id, d.title, d.content, d.created, d.user_id ".
				"FROM documents as d, tags as t ".
				"WHERE d.id = t.document_id AND repository_id = ? AND (?) ORDER BY RAND() LIMIT ?";
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($repository_id);
		$sqlQuery->setRawString($filters);
		$sqlQuery->setNumber($limit);
		
		return $this->getList($sqlQuery);
	}



/** Private functions **/
	
	/**
	 * Read row
	 *
	 * @return Repository
	 */
	protected function readRow($row){
		$document = new Document();
		
		$document->id = $row['id'];
		$document->title = $row['title'];
		$document->content = $row['content']; 
		$document->created = $row['created'];
		$document->author = DAOFactory::getUsersDAO()->load($row['user_id'])->toArray();
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