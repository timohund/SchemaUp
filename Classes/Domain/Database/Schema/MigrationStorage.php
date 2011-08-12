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
 * Holds all migration instructions.
 * 
 * @package SchemaUp
 * @subpackage Classes\Domain\Schema
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
class Domain_Database_Schema_MigrationStorage {
	
	/**
	 * @var ArrayObject
	 */
	protected $migrationSteps;
	
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->migrationSteps = new ArrayObject();
	}
	
	/**
	 * 
	 * @param string $migration
	 */
	public function add($migration) {
		$this->migrationSteps->append($migration);
	}
	
	/**
	 * Returns the number of migration steps.
	 * 
	 * @return int
	 */
	public function getCount() {
		return $this->migrationSteps->count();
	}
	
	/**
	 * Returns the string representation of the migration storage.
	 * 
	 * @return string
	 */
	public function _toString() {
		$result = '';
		for($it = $this->migrationSteps->getIterator(); $it->valid(); $it->next()) {
			$result .= $it->current()."; \n";
		}
		
		return trim($result);
	}
}