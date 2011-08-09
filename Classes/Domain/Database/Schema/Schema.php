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
class Domain_Database_Schema_Schema implements Interface_Visitable{
	
	/**
	 * @var $tables Domain_TableCollection
	 */
	protected $tables;
	
	/**
	 * @return void
	 */
	public function __construct() {
		$this->tables = new Domain_Database_Table_Collection();
	}
	
	/**
	 * Returns a table collection
	 * 
	 * @return Domain_Database_Table_Collection
	 */
	public function getTables() {
		return $this->tables;
	}
	
	/**
	 * Method to check if the schema has a table with the passed tablename.
	 * 
	 * @param Domain_Database_Table $table
	 */
	public function hasTable(Domain_Database_Table_Table $table) {
		return $this->getTables()->hasTable($table);
	}
	
	/**
	 * Retrieves a table from the schema.
	 * 
	 * @param Domain_Database_Table_Table $table
	 * @return Domain_Database_Table_Table
	 */
	public function getTable(Domain_Database_Table_Table $table) {
		return $this->getTables()->getTable($table);
	}
	
	/**
	 * Method to add a table to the schema.
	 * 
	 * @param Domain_Database_Table_Table $table
	 * @return Domain_Database_Schema_Schema
	 */
	public function addTable(Domain_Database_Table_Table  $table) {
		$this->getTables()->add($table);
		
		return $this;
	}
	
	/**
	 * Visitor implementation.
	 * 
	 * @param Interface_Visitor $visitor
	 */
	public function visit(Interface_Visitor $visitor) {
		$visitor->setVisitable($this);
		$this->tables->visit($visitor);
	}
}