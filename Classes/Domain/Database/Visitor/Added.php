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
 * Visits the target schema and checks for each node, if it
 * also extists in the source schema
 * 
 * @package SchemaUp
 * @subpackage Classes\Domain\Database\Visitor
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
class Domain_Database_Visitor_Added extends Domain_Database_Visitor_AbstractSchemaVisitor {
	
	/**
	 * @var Domain_Database_Schema_Schema
	 */
	protected $sourceSchema;
	
	/**
	 * @var Domain_Database_Schema_MigrationStorage
	 */
	protected $migrationStorage;
	
	/**
	 * @array array to remember added tables
	 */
	protected $addedTableNames = array();
	
	/**
	 * Method to pass the source schema, that should be
	 * used for comparision.
	 * 
	 * @param Domain_Database_Schema_Schema $sourceSchema
	 */
	public function setSourceSchema(Domain_Database_Schema_Schema $sourceSchema) {
		$this->sourceSchema = $sourceSchema;
	}
	
	/**
	 * Method to pass a migration storage that collects
	 * the migration information.
	 * 
	 * @param Domain_Database_Schema_MigrationStorage $migrationStorage
	 */
	public function setMigrationStorage(Domain_Database_Schema_MigrationStorage $migrationStorage) {
		$this->migrationStorage = $migrationStorage;
	}
	
	/**
	 * 
	 * @param Interface_Visitable $targetSchemaObject
	 */
	protected function doWork(Interface_Visitable $targetSchemaObject) {
		$class = get_class($targetSchemaObject);

		switch($class) {
			case 'Domain_Database_Table_Table':
				/** @var $targetSchemaObject Domain_Database_Schema_Table */
				if(!$this->sourceSchema->hasTable($targetSchemaObject)) {
					$this->migrationStorage->add($targetSchemaObject->getSql());
					$this->addedTableNames[] = $targetSchemaObject->getName();
				}
			break;
			
			case 'Domain_Database_Field_Field':
				$fieldTable = $this->getCurrentTable();
				if(!array_search($fieldTable->getName(),$this->addedTableNames)) {
					if($this->sourceSchema->hasTable($fieldTable)) {
						$sourceTable = $this->sourceSchema->getTable($fieldTable);
						if(!$sourceTable->hasField($targetSchemaObject)) {
							$this->migrationStorage->add("ALTER TABLE `".$fieldTable->getName()."` ADD ".$targetSchemaObject->getSql());
						}
					} else {
						//logic exception
					}
				}
			break;
		}
	}
}