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
 * Interface for factorys that can create objects from sql
 * 
 * @package SchemaUp
 * @subpackage Classes\Domain\Database
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
abstract class Domain_Database_AbstractSqlParsingFactory { 
	
	/**
	 * Creates an object from sql.
	 * 
	 * @param string $sql
	 * @return object
	 */
	abstract public function createFromSql($sql);
	
	/**
	 * Implementation should implement the method parseSql
	 * to do the internal parsing work.
	 * 
	 * @return boolean
	 */
	 abstract protected function parseSql();
}