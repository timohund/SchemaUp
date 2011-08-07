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
 * Object that represents a schema
 * 
 * @package SchemaUp
 * @subpackage Classes\Domain
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
class Domain_Database_Schema{
	
	/**
	 * @var $sqlString string
	 */
	protected $sqlString;
	
	/**
	 * @var $tables Domain_TableCollection
	 */
	protected $tables;
	
	/**
	 * @param string $sqlString
	 */
	public function __construct() {
		$this->tables = new Domain_Database_TableCollection();
	}
	
	/**
	 * Method to pass the sql string.
	 * 
	 * @param string $sql
	 * @return Domain_Database_Schema
	 */
	public function setSql($sql) {
		$this->sqlString = $sql;
		
		$this->parseSql();
		
		return $this;
	}
	
	/**
	 * Creates a table collection from the database schema.
	 * 
	 * @return void
	 */
	public function parseSql() {
		$matches = array();
			//; not followed by ' (not in data) or */ (not in comment)
		$matches = preg_split("~(?<statement>^;)*;(?!('|\*/))~ims",$this->sqlString);
		foreach($matches as $match) {
			if(preg_match("~^[[:space:]]*CREATE[[:space:]]+TABLE.*$~ims",$match) >= 1) {
				$createTableStatement = trim($match);
				
				$table = new Domain_Database_Table();
				$table->setSql($createTableStatement);
				
				$this->tables->add($table);
			}
		};
	}
	
	/**
	 * Returns a table collection
	 * 
	 * @return Domain_TableCollection
	 */
	public function getTables() {
		return $this->tables;
	}
}