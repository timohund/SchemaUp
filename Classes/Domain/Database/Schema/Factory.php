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
 * Factory class to create a schema object from an sql dump.
 * 
 * @package SchemaUp
 * @subpackage Classes\Domain\Database\Field
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
class Domain_Database_Schema_Factory extends Domain_Database_AbstractSqlParsingFactory {
	
	/**
	 * @var $tableFactory Domain_Database_Table_Factory
	 */
	protected $tableFactory;
	
	/**
	 * @var string
	 */
	protected $sqlString;
	
	/**
	 * @return void
	 */
	public function __construct() {
		$this->tableFactory = new Domain_Database_Table_Factory();
	}
	
	/**
	 * Creates the schema from an sql string (dump)
	 * 
	 * @param string
	 * @return Domain_Database_Schema_Schema
	 */
	public function createFromSql($sqlString) {
		$this->sqlString = $sqlString;
		return $this->parseSql();
	}
	
	/**
	 * Parses the sql and create a schema object.
	 * 
	 * @return Domain_Database_Schema_Schema
	 */
	protected function parseSql() {
		$schema = new Domain_Database_Schema_Schema();
		$schema->setSql($this->sqlString);
		$this->extractCreatedTables($schema);
		
		return $schema;
	}
	
	/**
	 * Creates a table collection from the database schema.
	 * 
	 * @param Domain_Database_Schema_Schema $schema
	 * @return Domain_Database_Schema_Factory
	 */
	protected function extractCreatedTables(Domain_Database_Schema_Schema $schema) {
		$matches = array();
			//; not followed by ' (not in data) or */ (not in comment)
		$matches = preg_split("~(?<statement>^;)*;(?!('|\*/))~ims",$this->sqlString);
		foreach($matches as $match) {
			if(preg_match("~^[[:space:]]*CREATE[[:space:]]+TABLE.*$~ims",$match) >= 1) {
				$createTableStatement = trim($match);
				$table = $this->tableFactory->createFromSql($createTableStatement);
				$schema->addTable($table);
			}
		};
	}
}