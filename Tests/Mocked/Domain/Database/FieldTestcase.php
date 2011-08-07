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
	
	/**
	 * Returns a array with field queries and expected fieldname.
	 * 
	 * @return array
	 */
	public function getFieldNameDataProvider() {
		return array(
			array(
				'createFieldSql' => '`id` int(11) unsigned NOT NULL',
				'expectedFieldName' => 'id',
			),
			array(
				'createFieldSql' => "	`period` date NOT NULL DEFAULT '0000-00-00'",
				'expectedFieldName' => 'period',
			),
			array(
				'createFieldSql' => " `redirectHttpStatusCode` int(4) unsigned NOT NULL DEFAULT '301'",
				'expectedFieldName' => "redirectHttpStatusCode"
			)
			
		);
	}
	
	/**
	 * Testcase to check if the fieldName can be extracted as expected.
	 * 
	 * @param string $createFieldSql
	 * @param string $expectedFieldName
	 * @test
	 * @dataProvider getFieldNameDataProvider
	 */
	public function getFieldName($createFieldSql, $expectedFieldName) {
		$currentFieldName = $this->field->setSql($createFieldSql)->getFieldname();
		$this->assertEquals($currentFieldName, $expectedFieldName, 'Retrieved unexpected fieldname from parsed field query');
	}
	
	/**
	 * Dataprovider with testdata to check if the dataType gets extracted as expected.
	 * 
	 * @return array
	 */
	public function getDataTypeDataProvider() {
		return array(
			array(
				'createFieldSql' => '`id` int(11) unsigned NOT NULL',
				'expectedDataType' => Domain_Database_Field::DATATYPE_INT,
				'expectedDataTypeAlias' => 'int'
			),
			array(
				'createFieldSql' => '`id` integer(11) unsigned NOT NULL',
				'expectedDataType' => Domain_Database_Field::DATATYPE_INT,
				'expectedDataTypeAlias' => 'integer'
			),
		);
	}
	
	/**
	 * Testcase to check if the dataType of a field gets determined as expected.
	 * 
	 * @param string $createFieldSql
	 * @param string $expectedDataType
	 * @param string $expectedDataTypeAlias
	 * @test
	 * @dataProvider getDataTypeDataProvider
	 */
	public function getDataType($createFieldSql, $expectedDataType, $expectedDataTypeAlias) {
		$currentDataType 		= $this->field->setSql($createFieldSql)->getDataType();
		$currentDataTypeAlias	= $this->field->getDataTypeAlias();
		
		$this->assertEquals($currentDataType, $expectedDataType, 'Field determined unexpected data type');
		$this->assertEquals($currentDataTypeAlias, $expectedDataTypeAlias, 'Field determined unexpected data type alias');
	}
}