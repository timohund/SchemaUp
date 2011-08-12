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
 * This testcase is used to check if the removed visitor
 * can determine remove table and field in the target schema,
 * that exist in the source schema
 *
 * @package SchemaUp
 * @subpackage Tests\Mocked\Domain\Database
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
class Mocked_Domain_Database_Visitor_RemovedTestcase extends Mocked_AbstractMockedTestcase {

	/**
	 * @var Domain_Database_Visitor_Removed
	 */
	protected $visitor;

	/**
	 * @return void
	 */
	public function setUp() {
		$this->visitor = new Domain_Database_Visitor_Removed();
	}

	/**
	 * This testcase is used to check if the removedVisitor adds
	 * a drop table statement for a removed table.
	 * 
	 * @test
	 * @return void
	 */
	public function setVisitableAddsDropTableForRemovedTable() {
		$targetSchemaMock = $this->getMock('Domain_Database_Schema_Schema');
		$targetSchemaMock->expects($this->any())->method('hasTable')->will($this->returnValue(false));
		$this->visitor->setTargetSchema($targetSchemaMock);

		$field		= new Domain_Database_Field_Field();
		$field->setName('name');

		$table		= new Domain_Database_Table_Table();
		$table->addField($field)->setName('author');

		$migrationStorage = new Domain_Database_Schema_MigrationStorage();
		$this->visitor->setMigrationStorage($migrationStorage);

		$this->assertEquals(0, $migrationStorage->getCount(), 'Unexpected number of migrations in migration storage');
		$this->visitor->setVisitable($table);
		$this->assertEquals(1, $migrationStorage->getCount(), 'Unexpeted number if migrations in the migration storage');
		$this->assertEquals('DROP TABLE `author`;',trim($migrationStorage->_toString()),'Migration storage contains unexpected content');;
	}

	/**
	 * This testcase is used to check if the removedVisitors add an
	 * ALTER TABLE REMOVE `fieldname` for an removed field in a table.
	 *
	 * @test
	 * @return field
	 */
	public function setVisitableAddsAlterTableRemoveForRemovedField() {
		$tableMock			= $this->getMock('Domain_Database_Table_Table');
		$tableMock->expects($this->any())->method('hasField')->will($this->returnValue(false));

		$targetSchemaMock = $this->getMock('Domain_Database_Schema_Schema');
		$targetSchemaMock->expects($this->any())->method('hasTable')->will($this->returnValue(true));
		$targetSchemaMock->expects($this->any())->method('getTable')->will($this->returnValue($tableMock));
		$this->visitor->setTargetSchema($targetSchemaMock);

		$migrationStorage = new Domain_Database_Schema_MigrationStorage();
		$this->visitor->setMigrationStorage($migrationStorage);

		$field		= new Domain_Database_Field_Field();
		$field->setName('name');

		$table		= new Domain_Database_Table_Table();
		$table->addField($field)->setName('author');
		$this->visitor->setVisitable($table);

		$this->assertEquals(0, $migrationStorage->getCount(), 'Unexpected number of migrations in migration storage');
		$this->visitor->setVisitable($field);
		$this->assertEquals(1, $migrationStorage->getCount(), 'Unexpeted number if migrations in the migration storage');
		$this->assertEquals('ALTER TABLE `author` DROP `name`;',trim($migrationStorage->_toString()),'Migration storage contains unexpected content');;
	}
}
