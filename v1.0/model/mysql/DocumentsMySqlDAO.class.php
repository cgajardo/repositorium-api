<?php
/**
 * 
 * @author: cgajardo
 * @date: 2012-05-08 16:32
 */
class DocumentsMySqlDAO implements DocumentsDAO{

/** Public functions **/
	
	public function inactive($document_id){
		$sql = "UPDATE documents SET active = 0 WHERE id = ?";
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($document_id);
		
		return $this->executeUpdate($sqlQuery);
	}
	
	public function update($Document){
		$sql = "UPDATE documents SET title = ?, content = ? WHERE id = ?";
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setString($Document->title);
		$sqlQuery->setString($Document->content);
		$sqlQuery->setString($Document->id);
		
		return $this->executeUpdate($sqlQuery);
	}
	
	public function insert($Document, $repo_id){
		$sql = "INSERT INTO documents (title, content, user_id, created, modified, repository_id) ".
				"VALUES (?, ?, ?, ?, ?, ?)";
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setString($Document->title);
		$sqlQuery->setString($Document->content);
		$sqlQuery->setNumber($Document->author);
		$sqlQuery->setString($Document->created);
		$sqlQuery->setString($Document->created);
		$sqlQuery->setNumber($repo_id);
		
		$id = $this->executeInsert($sqlQuery);
		
		//if documen has tags, add them
		if($Document->tags != null){
			foreach($Document->tags as $tag){
				$sql = "INSERT INTO tags (document_id, tag, created, modified) ".
						"VALUES (?,?,?,?)";
				
				$sqlQuery = new SqlQuery($sql);
				$sqlQuery->setNumber($id);
				$sqlQuery->setString($tag);
				$sqlQuery->setString($Document->created);
				$sqlQuery->setString($Document->created);
				$this->executeInsert($sqlQuery);
			}
			
		}
		
		//if document has files, add them
		if($Document->files != null){
			foreach($Document->files as $file){
				$sql = "INSERT INTO attachfiles (filename, type, size, content, document_id) ".
						"VALUES(?,?,?,?,?)";
				
				$sqlQuery = new SqlQuery($sql);
				$sqlQuery->setString($file['filename']);
				$sqlQuery->setString($file['type']);
				$sqlQuery->setNumber($file['size']);
				$sqlQuery->setNumber($id);
				
				$this->executeInsert($sqlQuery);
			}
		
		}
		
		$this->massCreateAfterDocument($id, $repo_id);
	}
	
	private function massCreateAfterDocument($doc_id, $repo_id){
		$sql = "SELECT id FROM criterias WHERE repository_id = ?";
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($repo_id);
		
		$tab = QueryExecutor::execute($sqlQuery);
		for($i=0;$i<count($tab);$i++){
			$sql = "INSERT INTO criterias_documents(document_id, criteria_id, total_answers_1, total_answers_2, validated, challengeable) ".
					"VALUES(?,?,0,0,0,1)";
			$sqlQuery = new SqlQuery($sql);
			$sqlQuery->setNumber($doc_id);
			$sqlQuery->setNumber($tab[$i]['id']);
			$this->executeInsert($sqlQuery);
		}
	}
	
	public function load($document_id){
		$sql = "SELECT d.id, d.title, d.content, d.created, d.user_id ".
				"FROM documents as d, tags as t ".
				"WHERE d.id = ?";
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($document_id);
		
		return $this->getRow($sqlQuery);
		
	}
	
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
	 * Return the list of tags for a document
	 * 
	 * @param int $docId
	 * @return array
	 */
	private function queryTags($docId){
		$sql = "SELECT tag FROM tags WHERE document_id = ?";
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($docId);
		
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$ret[$i] = $tab[$i]['tag'];
		}
		return $ret;
	}
	
	private function queryFiles($docId){
		$sql = "SELECT filename, type, size, content FROM attachfiles WHERE document_id = ?";
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($docId);
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$ret[$i] = array("filename"=>$tab[$i]['filename'],"type"=>$tab[$i]['type'], 
					"content"=>$tab[$i]['content'], "size"=>$tab[$i]['size']);
		}
		return $ret;	
	}
	
	
	/**
	 * Read row
	 *
	 * @return Document
	 */
	protected function readRow($row){
		$document = new Document();
		
		$document->id = $row['id'];
		$document->title = $row['title'];
		$document->content = $row['content']; 
		$document->created = $row['created'];
		$document->author = DAOFactory::getUsersDAO()->load($row['user_id'])->toArray();
		$document->tags = $this->queryTags($row['id']);
		$document->files = $this->queryFiles($row['id']);

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
	 * @return Document 
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