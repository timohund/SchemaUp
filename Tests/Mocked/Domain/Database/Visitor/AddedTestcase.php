<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Timo Schmidt <timo-schmidt@gmx.net>
*  All rights reserved
*
*  This copyright notice MUST APPEAR in all copies of the script!
****************************************************************/

/**
 * Testcase to test the functionallity of the visitor
 * that should determined added tables and fields 
 * in the new schema.
 * 
 * @package SchemaUp
 * @subpackage Tests\Mocked\Domain\Database
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
class Mocked_Domain_Database_Visitor_AddedTestcase extends Mocked_AbstractMockedTestcase {

	/**
	 * @var $visitor Domain_Database_Visitor_Added
	 */
	protected $visitor; 
	
	public function setUp() {
		$this->visitor = new Domain_Database_Visitor_Added();
	}
	
	/**
	 * This testcase is used to test if the Added visitor adds a create table statetement 
	 * for a none existing table.
	 * 
	 * @test
	 */
	public function setVisitorAddsCreateTableForNonExistingTable() {
		$sourceSchemaMock = $this->getMock('Domain_Database_Schema_Schema');
		$sourceSchemaMock->expects($this->any())->method('hasTable')->will($this->returnValue(false));
		
		$migrationStorage = new Domain_Database_Schema_MigrationStorage();
		$this->visitor->setMigrationStorage($migrationStorage);	
		$this->visitor->setSourceSchema($sourceSchemaMock);
		
		$targetSchemaTable = new Domain_Database_Table_Table();
		$targetSchemaTable->setName('Foobar');
		$targetSchemaTable->setSql('CREATE TABLE foobar ();');
		
		//before we visit anything the migration storage should not contain any migrations
		$this->assertEquals(0, $migrationStorage->getCount(), 'Migrationstorage contains unexpected number of items');
		$this->visitor->setVisitable($targetSchemaTable);
		$this->assertEquals(1, $migrationStorage->getCount(), 'Migrationstorage contains unexpected number of items');
	}
	
	/**
	 * The visitor for added content visits all tables and fields.
	 * Whenever a complete table is added, the visitor should not added the field its self
	 * whever the field gets processed.
	 * 
	 * @test
	 */
	public function setVisitableAddsCreateTableOnlyOnceWhenFieldFromSameTableGetsProcessed() {
		$sourceSchemaMock = $this->getMock('Domain_Database_Schema_Schema');
		$sourceSchemaMock->expects($this->any())->method('hasTable')->will($this->returnValue(false));
		
		$migrationStorage = new Domain_Database_Schema_MigrationStorage();
		$this->visitor->setMigrationStorage($migrationStorage);	
		$this->visitor->setSourceSchema($sourceSchemaMock);
		
		$targetSchemaTable = new Domain_Database_Table_Table();
		$targetSchemaTable->setName('Foobar');
		$targetSchemaTable->setSql('CREATE TABLE foobar ();');
		
		//before we visit anything the migration storage should not contain any migrations
		$this->assertEquals(0, $migrationStorage->getCount(), 'Migrationstorage contains unexpected number of items');
		$this->visitor->setVisitable($targetSchemaTable);
		$this->assertEquals(1, $migrationStorage->getCount(), 'Migrationstorage contains unexpected number of items');
		
		$targetSchemaField = new Domain_Database_Field_Field();
		$targetSchemaField->setName('id');
		$targetSchemaField->setSql('`id` int(11) unsigned NOT NULL');
		$this->visitor->setVisitable($targetSchemaField);
		
		$this->assertEquals(1, $migrationStorage->getCount(), 'Migrationstorage contains unexpected number of items, field from unexisting table was also added');
	}
	
	/**
	 * This testcase is used to test if the visitor adds an ALTER TABLE `` ADD ... statement for
	 * a new column.
	 * 
	 * @test
	 */
	public function setVisitableAddsAlterTableForNewColumns() {
		$sourceTableMock = $this->getMock('Domain_Database_Table_Table');
		$sourceTableMock->expects($this->any())->method('hasField')->will($this->returnValue(false));
		
		$sourceSchemaMock = $this->getMock('Domain_Database_Schema_Schema');
		$sourceSchemaMock->expects($this->any())->method('hasTable')->will($this->returnValue(true));
		$sourceSchemaMock->expects($this->any())->method('getTable')->will($this->returnValue($sourceTableMock));
		
		$migrationStorage = new Domain_Database_Schema_MigrationStorage();
		$this->visitor->setMigrationStorage($migrationStorage);	
		$this->visitor->setSourceSchema($sourceSchemaMock);
		
		$targetSchemaField = new Domain_Database_Field_Field();
		$targetSchemaField->setName('id');
		$targetSchemaField->setSql('`id` int(11) unsigned NOT NULL');
		
		$targetSchemaTable = new Domain_Database_Table_Table();
		$targetSchemaTable->setName('test');
		$targetSchemaTable->setSql('CREATE TABLE test ();');
		
		$this->visitor->setVisitable($targetSchemaTable);
		
		$this->assertEquals(0, $migrationStorage->getCount(), 'Migrationstorage contains unexpected number of items it should be empty');
		
		$this->visitor->setVisitable($targetSchemaField);
		
		$this->assertEquals(1, $migrationStorage->getCount(), 'Migrationstorage contains unexpected number of items field shoud produce an ALTER TABLE statement');		
		$expectedQuery = 'ALTER TABLE `test` ADD `id` int(11) unsigned NOT NULL;';
		
		$this->assertEquals($expectedQuery, trim($migrationStorage->_toString()),'Migrationstorage contains unexpected query');
	}
}