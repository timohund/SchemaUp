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
 * Collection of database table information objects
 * 
 * @package SchemaUp
 * @subpackage Classes\System
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
class Domain_Database_Table_Collection extends System_AbstractCollection implements Interface_Visitable{

	/**
	 * Method to add a table to the table collection.
	 * 
	 * @param Domain_Database_Table $table
	 */
	public function addTable(Domain_Database_Table_Table $table) {
		parent::add($table);
	}
	
	/**
	 * This method is used to check if a table with
	 * a given name is in the table collection.
	 * 
	 * @param Domain_Database_Table_Table $table
	 * @return boolean
	 */
	public function hasTable(Domain_Database_Table_Table $tableToSearch) {
		return $this->getTable($tableToSearch) !== false;
	}
	
	/**
	 * Method to retrieve a table from the table collection.
	 * 
	 * @param Domain_Database_Table_Table $tableToSearch
	 * @return Domain_Database_Table_Table returns the table or false if the table is not in the collection
	 */
	public function getTable(Domain_Database_Table_Table $tableToSearch) {
		$result = false;
		
		for($it = $this->getIterator(); $it->valid(); $it->next()) {
			if($it->current()->getName() == $tableToSearch->getName()) {
				$result = $it->current();
				break;
			}
		}
		
		return $result;
	}
	
	/**
	 * Implementation of the visitor interface. 
	 * 
	 * @param Interface_Visitor $visitor
	 */
	public function visit(Interface_Visitor $visitor) {
		$visitor->setVisitable($this);
		for($it = $this->getIterator(); $it->valid(); $it->next()) {
				/* $currentTable Domain_Database_Table_Table */
			$currentTable = $it->current();
			$currentTable->visit($visitor);
		}
	}
}