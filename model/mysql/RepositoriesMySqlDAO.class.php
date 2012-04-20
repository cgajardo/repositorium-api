<?php
/**
 * 
 * @author: cgajardo
 * @date: 2012-04-20 00:52
 */
class RepositoriesMySqlDAO implements RepositoriesDAO{

/** Public functions **/

	public function queryAll(){
		$sql = "SELECT id, name, description, user_id FROM repositories";
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
		//TODO:mejorar
		$repository->author = $row['user_id'];

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