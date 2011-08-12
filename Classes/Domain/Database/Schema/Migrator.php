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
class Domain_Database_Schema_Migrator{
	
	/**
	 * @var Domain_Database_Schema
	 */
	protected $sourceSchema;
	
	/**
	 * @var Domain_Database_Schema
	 */
	protected $targetSchema;

	/**
	 * @var Domain_Database_Visitor_Added
	 */
	protected $addedVisitor;

	/**
	 * @var Domain_Database_Visitor_Removed
	 */
	protected $removedVisitor;

	/**
	 * @var Domain_Database_Schema_MigrationStorage
	 */
	protected $migrationStorage;

	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {	}
	
	/**
	 * Method to set the source schema for the migration.
	 * 
	 * @param Domain_Database_Schema_Schema $sourceSchema
	 * @return Domain_Database_SchemaMigrator
	 */
	public function setSourceSchema(Domain_Database_Schema_Schema $sourceSchema) {
		$this->sourceSchema = $sourceSchema;	
		return $this;
	}
	
	/**
	 * Method to set the target schema for the migrator.
	 * 
	 * @param Domain_Database_Schema_Schema $targetSchema
	 * @return Domain_Database_SchemaMigrator
	 */
	public function setTargetSchema(Domain_Database_Schema_Schema $targetSchema) {
		$this->targetSchema = $targetSchema;
		return $this;
	}
	
	/**
	 * Method that does the migration.
	 * 
	 * @return boolean
	 */
	protected function migrate() {
		$this->migrationStorage 	= new Domain_Database_Schema_MigrationStorage();
		$this->addedVisitor 		= new Domain_Database_Visitor_Added();
		$this->removedVisitor		= new Domain_Database_Visitor_Removed();

		$this->addedVisitor->setMigrationStorage($this->migrationStorage);
		$this->addedVisitor->setSourceSchema($this->sourceSchema);
		$this->targetSchema->visit($this->addedVisitor);

		$this->removedVisitor->setMigrationStorage($this->migrationStorage);
		$this->removedVisitor->setTargetSchema($this->targetSchema);
		$this->sourceSchema->visit($this->removedVisitor);
	}
	
	/**
	 * Method to retrieve the collaction of migration statements.
	 * 
	 * @return Domain_Database_StatementCollection
	 */
	public function getMigrationStatements() {
		$this->migrate();
		return $this->migrationStorage->_toString();
	}
}