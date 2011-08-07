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
 * Schema Migrator used to generate the sql statements
 * that are needed to transform a source database schema to 
 * a target database schema.
 * 
 * @package SchemaUp
 * @subpackage Classes\Domain
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
class Domain_Database_SchemaMigrator{
	
	/**
	 * @var Domain_Database_Schema
	 */
	protected $sourceSchema;
	
	/**
	 * @var Domain_Database_Schema
	 */
	protected $targetSchema;
	
	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		$this->migrationStatements = new Domain_Database_StatementCollection();
	}
	
	/**
	 * Method to set the source schema for the migration.
	 * 
	 * @param Domain_Database_Schema $sourceSchema
	 * @return Domain_Database_SchemaMigrator
	 */
	public function setSourceSchema(Domain_Database_Schema $sourceSchema) {
		$this->sourceSchema = $sourceSchema;	
		return $this;
	}
	
	/**
	 * Method to set the target schema for the migrator.
	 * 
	 * @param Domain_Database_Schema $targetSchema
	 * @return Domain_Database_SchemaMigrator
	 */
	public function setTargetSchema(Domain_Database_Schema $targetSchema) {
		$this->targetSchema = $targetSchema;
		return $this;
	}
	
	/**
	 * Method that does the migration.
	 * 
	 * @return boolean
	 */
	protected function migrate() {
		foreach($this->targetSchema->getTables() as $targetTable) {
			if($this->sourceSchema->hasTable($targetTable)) {
					//retrieve the table from the source schema
				$sourceTable = $this->sourceSchema->getTable($targetTable);
				
				//source schema has the same table are all fields in the
				//source schema?
				foreach($targetTable->getFields() as $targetField) {
					if($sourceTable->hasField($targetField)) {
						//check datatype collation etc and add statements to change them if needed
					} else {
						//new field apped field creation for table
					}
				}
			} else {
				//table is completely missig in the source schema
				//create a new table
			}
		}
	}
	
	/**
	 * Method to retrieve the collaction of migration statements.
	 * 
	 * @return Domain_Database_StatementCollection
	 */
	public function getMigrationStatements() {
		$this->migrate();
		return $this->migrationStatements;
	}
}