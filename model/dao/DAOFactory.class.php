<?php

/**
 * DAOFactory
 * @author: cgajardo
 * @date: 2012-04-20 01:29
 */
class DAOFactory{
	
	/**
	 * @return DocumentsDAO
	 */
	public static function getDocumentsDAO(){
		return new DocumentsMySqlDAO();
	}
	
	/**
	 * @return RepositoriesDAO
	 */
	public static function getRepositoriesDAO(){
		return new RepositoriesMySqlDAO();
	}
	
	/**
	 * @return UsersDAO
	 */
	public static function getUsersDAO(){
		return new UsersMySqlDAO();
	}
	
	/**
	 * @return ChallengesDAO
	 */
	public static function getChallengesDAO(){
		return new ChallengesMySqlDAO();
	}


}
?>