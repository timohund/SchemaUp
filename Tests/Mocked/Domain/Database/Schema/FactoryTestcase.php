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
 * Testcase to test the functionallity of the schema class
 * 
 * @package SchemaUp
 * @subpackage Tests\Mocked\Domain\Database
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
class Mocked_Domain_Database_SchemaTestcase extends Mocked_AbstractMockedTestcase {
	
	/**
	 * Testcase to check if the tables can be parsed from the dump.
	 * 
	 * @test 
	 */
	public function extractTables() {
		$fixtureSql		= $this->getFixtureContent('dump1.sql',__FILE__);
		$schemaFactory	= new Domain_Database_Schema_Factory();
		$schema			= $schemaFactory->createFromSql($fixtureSql);
		
		$this->assertEquals(6,$schema->getTables()->getCount(),'Unexpected number of tables in the schema');
	}
}