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
 * also exists in the source schema.
 * 
 * @package SchemaUp
 * @subpackage Classes\Domain\Database\Visitor
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
class Domain_Database_Visitor_Added extends Domain_Database_Visitor_AbstractMigratingSchemaVisitor {

	/**
	 * @var Domain_Database_Schema_Schema
	 */
	protected $sourceSchema;
	
	/**
	 * @array array to remember added tables
	 */
	protected $addedTableNames = array();
	
	/**
	 * Method to pass the source schema, that should be
	 * used to compare.
	 * 
	 * @param Domain_Database_Schema_Schema $sourceSchema
	 * @return Domain_Database_Visitor_Added
	 */
	public function setSourceSchema(Domain_Database_Schema_Schema $sourceSchema) {
		$this->sourceSchema = $sourceSchema;
		return $this;
	}

	/**
	 * The do work method is called by the abstract method to
	 * check each node. In case of the AddedVisitor it should determine
	 * all new added tables and fields in the target schema.
	 * 
	 * @param Interface_Visitable $targetSchemaObject
	 */
	protected function doWork(Interface_Visitable $targetSchemaObject) {
		$class = get_class($targetSchemaObject);

		switch($class) {
			case 'Domain_Database_Table_Table':
				/** @var $targetSchemaObject Domain_Database_Table_Table */
				if(!$this->sourceSchema->hasTable($targetSchemaObject)) {
					$this->migrationStorage->add($targetSchemaObject->getSql());
					$this->addedTableNames[] = $targetSchemaObject->getName();
				}
			break;
			
			case 'Domain_Database_Field_Field':
				/** @var $targetSchemaObject Domain_Database_Field_Field */
				$fieldTable = $this->getCurrentTable();
				if(array_search($fieldTable->getName(),$this->addedTableNames) === false) {
					if($this->sourceSchema->hasTable($fieldTable)) {
						$sourceTable = $this->sourceSchema->getTable($fieldTable);
						if(!$sourceTable->hasField($targetSchemaObject)) {
							$this->migrationStorage->add("ALTER TABLE `".$fieldTable->getName()."` ADD ".$targetSchemaObject->getSql());
						}
					} else {
						$message = "The AddedVisitor tried to retrieve an table (".$fieldTable->getName().") from the sourceSchema that was previously processed.";
						throw new Exception_Visitor_LogicException($message);
					}
				}
			break;
		}
	}
}