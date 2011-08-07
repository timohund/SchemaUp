<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Timo Schmidt <timo-schmidt@gmx.net>
*  All rights reserved
*
*
*  This copyright notice MUST APPEAR in all copies of the script!
****************************************************************/

/**
 * Interface for classes that deal with sql parsing.
 * 
 * @package SchemaUp
 * @subpackage Classes\Interface
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
interface Interface_SqlParser { 
	
	/**
	 * Method to set the sql string.
	 * 
	 * @param string $sql
	 * @return Interface_SqlParser
	 */
	public function setSql($sql);
	
	/**
	 * Implementation should implement the method parseSql
	 * to do the internal parsing work.
	 * 
	 * @return boolean
	 */
	public function parseSql();
}