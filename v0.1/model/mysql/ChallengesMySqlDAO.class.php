<?php
/**
 * 
 * @author: cgajardo
 * @date: 2012-04-26 23:35
 */
class ChallengesMySqlDAO implements ChallengesDAO{

/** Public functions **/
	
	public function getChallenges($repository_id, $user_id){
		
		//get a random criteria in the repository
		$sql = "SELECT id, question, answer_1, answer_2 ".
				"FROM criterias ".
				"WHERE  repository_id = ? ".
				"ORDER BY RAND() ".
				"LIMIT 1";
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($repository_id);
		$row = QueryExecutor::execute($sqlQuery);
		
		//ERROR: no criteria in this repository
		if($row == null){
			$Error = new Error();
			$Error->status = "500 Internal Server Error";
			$Error->message = "There is no criteria in this repository. Please contact repository admin.";
			return $Error;
		}
		
		$challenge = $row[0];
		
		return $challenge['id'];
		
		//get challenge size for user in this criteria
		$sql = "SELECT challenge_size AS size ".
				"FROM criterias_users ".
				"WHERE user_id = ? AND criteria_id = ?";
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($user_id);
		$sqlQuery->setNumber($challenge['id']);
		$row = QueryExecutor::execute($sqlQuery);
		$size = $row[0]['size'];
		
		//TODO: proporción de validados y no validados???
		$documents = DAOFactory::getDocumentsDAO()->queryForChallenge($challenge['id'], $size);
		
		//ERROR: no enough documents
		if($documents == null){
			$Error = new Error();
			$Error->status = "500 Internal Server Error";
			$Error->message = "There aren't enough documents to play a challenge.";
			return $Error;
		}
		
		//build an array to put in session in order to check answers from user
		$challengeToSession = array();
		$challengeToSession['idcriteria'] = $challenge['id'];
		
		//to obscure data to user
		$i = 1;
		foreach ($documents as $document){
			$challengeToSession[$i] = $document->id;
			$document->id = $i;
			$i++;
		}
		
		$idChallengeInSession = substr(md5($challenge['id']),0,9);
		//this is awfull
		getSession()->set($idChallengeInSession, $challengeToSession);
		
		$Challenge = new Challenge();
		$Challenge->id = $idChallengeInSession;
		$Challenge->question = $challenge['question'];
		$Challenge->answera = $challenge['answer_1'];
		$Challenge->answerb = $challenge['answer_2'];
		$Challenge->documents = $documents;
		
		return $Challenge;
		
	}
	

/** Private functions **/
	
	/**
	 * Read row
	 *
	 * @return Challenge
	 */
	protected function readRow($row){
		$Challenge = new Challenge();
		$Challenge->question = $row['question'];
		//TODO: do document load;
		//$Challenge->documents = array(DAOFactory::getDocumentsDAO()->load());
		$Challenge->answera = $row['answera'];
		$Challenge->answerb = $row['answerb'];
		
		return $Challenge;
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