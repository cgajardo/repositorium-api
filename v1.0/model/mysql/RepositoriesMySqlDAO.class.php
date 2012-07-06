<?php
/**
 * 
 * @author: cgajardo
 * @date: 2012-04-20 00:52
 */
class RepositoriesMySqlDAO implements RepositoriesDAO{

/** Public functions **/
	
	public function getTags($repository_id){
		$sql = "SELECT DISTINCT(tag) ".
			"FROM tags AS t, documents AS d, repositories AS r ".
			"WHERE d.id = t.document_id AND d.repository_id = r.id AND r.id = ?";
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($repository_id);
		
		$rows = $this->execute($sqlQuery);
		
		$ret = array();
		for($i=0;$i<count($rows);$i++){
			$ret[$i] = $rows[$i]['tag'];
		}
		
		return $ret;
	}
	
	public function getCriterion($repository_id){
		$sql = "SELECT id FROM criterias WHERE repository_id = ?";
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($repository_id);
		
		$rows = $this->execute($sqlQuery);
		
		$ret = array();
		for($i=0;$i<count($rows);$i++){
			$ret[$i] = $rows[$i]['id'];
		}
		
		return $ret;
	}
	
	public function getNumberOfCriterion($repository_id){
		$sql = "SELECT count(*) FROM criterias where repository_id = ?";
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($repository_id);
		
		return $this->querySingleResult($sqlQuery);
	}
	
	public function getNumberOfDocuments($repository_id){
	
		$sql = "SELECT count(*) FROM documents WHERE repository_id = ?";
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($repository_id);
	
		return $this->querySingleResult($sqlQuery);
	}
	
	
	public function getNumberOfUsers($repository_id){
		$sql = "SELECT count(*) FROM repositories_users where repository_id = ?";
	
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($repository_id);
	
		return $this->querySingleResult($sqlQuery);
	}
	
	public function queryForUser($email){
		$sql = "SELECT * from repositories WHERE id IN (".
					"SELECT repository_id FROM repositories_users WHERE user_id IN (".
						"SELECT id FROM users WHERE email = ?))";
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setString($email);
		
		return $this->getList($sqlQuery);
	}
	
	public function getPackSize($repository_id){
		$sql = "SELECT documentpack_size FROM repositories WHERE id = ?";
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($repository_id);
		
		return $this->querySingleResult($sqlQuery);
	}
	
	public function getDownloadCost($repository_id){
		$sql = "SELECT download_cost FROM repositories WHERE id = ?";
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($repository_id);
		
		return $this->querySingleResult($sqlQuery);
	}
	
	public function load($repository_id){
		$sql = "SELECT id, name, description, user_id, active FROM repositories WHERE id = ?";
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($repository_id);
		
		return $this->getRow($sqlQuery);
	}

	public function queryAll(){
		$sql = "SELECT id, name, description, user_id, active FROM repositories";
		$sqlQuery = new SqlQuery($sql);
		
		return $this->getList($sqlQuery);
	}


/** Private functions **/
	
	/**
	 * Read row
	 *
	 * @return Repository
	 */
	protected function readRow($row){
		$repository = new Repository();
		
		$repository->id = $row['id'];
		$repository->name = $row['name'];
		$repository->description = $row['description'];
		$repository->author = DAOFactory::getUsersDAO()->load($row['user_id']);
		$repository->active = $row['active'];

		return $repository;
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