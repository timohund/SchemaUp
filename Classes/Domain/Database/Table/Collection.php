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
class Domain_Database_Table_Collection extends System_AbstractCollection implements Interface_Compareable{

	/**
	 * Method to add a table to the table collection.
	 * 
	 * @param Domain_Database_Table $table
	 */
	public function add(Domain_Database_Table_Table $table) {
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
	 * Compares the table collection to another table collection.
	 * 
	 * @param Domain_Database_Table_Collection $toCompate
	 */
	public function equals($toCompare) {
		$equals = true;
		$equals = $equals && ($this->getCount() == $toCompare->getCount());
		
			//if the collection contain a diffrent amount of tables, we
			//do not need to compare them.
		if($equals) {
			for($it = $this->getIterator(); $it->valid(); $it->next()) {
				//@var $currentTable Domain_Database_Table_Table
				$currentTableSourceSchema = $it->current();
				$currentTableTargetSchema = $toCompare->getTable($currentTableSourceSchema);
				
				if($currentTableTargetSchema instanceof Domain_Database_Table_Table) {
					$equals = $equals && $currentTableSourceSchema->equals($currentTableTargetSchema);
				} else {
					$equals = false;
				}
				
					//as soon as equals is false we can set equals to false and return
				if(!$equals) {
					$equals = false;
					break;
				}
			}
		}
		
		return $equals;
	}
}