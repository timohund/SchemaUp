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
class Mocked_Domain_Database_FieldTestcase extends Mocked_AbstractMockedTestcase {
	
	/**
	 * @var $field Domain_Database_Field
	 */
	protected $field;
	
	/**
	 * @return void
	 */
	public function setUp() {
		$this->field = new Domain_Database_Field();
	}
	
	/**
	 * Dataprovider with field definition an expected auto increment state.
	 * 
	 * @return array
	 */
	public function getAutoIncrementDataProvider() {
		return array(
			array( 	
				'createFieldSql' => ' 	`id` int(11) unsigned NOT NULL',
				'expectIsAutoIncrement' => false
			),
			array( 	
				'createFieldSql' => '`id` int(11) unsigned NOT NULL AUTO_INCREMENT ',
				'expectIsAutoIncrement' => true
			),
		);
	}
	
	/**
	 * Testcase to check if a given field is an auto increment field.
	 * 
	 * @param string $createFieldSql
	 * @param boolean $expectIsAutoIncrement
	 * @test
	 * @dataProvider getAutoIncrementDataProvider
	 */
	public function getAutoIncrement($createFieldSql, $expectIsAutoIncrement) {
		$currentAutoIncrementState = $this->field->setSql($createFieldSql)->getAutoIncrement();

		$assertMessage = 'Field has unexpected getAutoIncrement state: '.var_export($currentAutoIncrementState, true);
		$this->assertEquals($currentAutoIncrementState,$expectIsAutoIncrement,$assertMessage);
	}
}