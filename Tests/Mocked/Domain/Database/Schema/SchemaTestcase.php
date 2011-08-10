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
 * Autoloader class for schema up components.
 * 
 * @package SchemaUp
 * @subpackage Tests\Mocked\Domain\Database
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
class Mocked_Domain_Database_Schema_SchemaTestcase extends Mocked_AbstractMockedTestcase {
	
	/**
	 * @var $schema Domain_Database_Database_Schema
	 */
	protected $schema;
	
	/**
	 * @return void
	 */
	public function setUp() {
		$this->schema = new Domain_Database_Schema_Schema();
	}
	
	/**
	 * Method to test if the hasTable method works as expected.
	 * 
	 * @test
	 */
	public function hasTable() {
		$table = new Domain_Database_Table_Table();
		$table->setName('foobar');
		
		$this->assertFalse( $this->schema->hasTable($table), 'Schema indicates to contain unexpected table' );
		
		$this->schema->addTable($table);
		
		$this->assertTrue( $this->schema->hasTable($table), 'Schema does not indicate containing table');	
	}

	/**
	 * Testcase to test the equals method.
	 * 
	 * @test
	 */
	public function visit() {
		$fieldA = new Domain_Database_Field_Field();
		$fieldA->setDatatype(Domain_Database_Field_Factory::DATATYPE_INT);
		$fieldA->setName('id');
		
		$fieldB = new Domain_Database_Field_Field();
		$fieldB->setDatatype(Domain_Database_Field_Factory::DATATYPE_VARCHAR);
		$fieldB->setName('name');
		
		$table	 = new Domain_Database_Table_Table();
		$table->setName('users');
		$table->addField($fieldA)->addField($fieldB);
		
		$schema = new Domain_Database_Schema_Schema();
		$schema->addTable($table);
	
		$countVisitor = new Domain_Database_Visitor_Count();
		$schema->visit($countVisitor);
		
		$this->assertEquals(2, $countVisitor->getFieldNodeCount(),'Unexpected number of fields');
		$this->assertEquals(1, $countVisitor->getTableNodeCount(),'Unexpected number of tables');
		$this->assertEquals(1, $countVisitor->getSchemaNodeCount(),'Unexpected number of schemas');	
	}
}