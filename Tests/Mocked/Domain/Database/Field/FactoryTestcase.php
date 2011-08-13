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
 * Testcase to test if the field factory can create a  field object from the sql field
 * definition.
 * 
 * @package SchemaUp
 * @subpackage Tests\Mocked\Domain\Database
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
class Mocked_Domain_Database_Field_FactoryTestcase extends Mocked_AbstractMockedTestcase {
	
	/**
	 * @var $factory Domain_Database_Field_Factory
	 */
	protected $factory;
	
	/**
	 * @return void
	 */
	public function setUp() {
		$this->factory = new Domain_Database_Field_Factory();
	}
	
	/**
	 * Dataprovider with field definition an expected auto increment state.
	 * 
	 * @return array
	 */
	public function extractAutoIncrementDataProvider() {
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
	 * @dataProvider extractAutoIncrementDataProvider
	 */
	public function extractAutoIncrement($createFieldSql, $expectIsAutoIncrement) {
		$field = $this->factory->createFromSql($createFieldSql);
		$currentAutoIncrementState = $field->getAutoIncrement();

		$assertMessage = 'Field has unexpected getAutoIncrement state: '.var_export($currentAutoIncrementState, true);
		$this->assertEquals($currentAutoIncrementState,$expectIsAutoIncrement,$assertMessage);
	}
	
	/**
	 * Returns a array with field queries and expected fieldname.
	 * 
	 * @return array
	 */
	public function extractNameDataProvider() {
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
	 * @dataProvider extractNameDataProvider
	 */
	public function extractNameTest($createFieldSql, $expectedFieldName) {
		$currentFieldName = $this->factory->createFromSql($createFieldSql)->getName();
		$this->assertEquals($currentFieldName, $expectedFieldName, 'Retrieved unexpected fieldname from parsed field query');
	}
	
	/**
	 * Dataprovider with testdata to check if the dataType gets extracted as expected.
	 * 
	 * @return array
	 */
	public function extractDataTypeDataProvider() {
		return array(
			array(
				'createFieldSql' => '`id` int(11) unsigned NOT NULL',
				'expectedDataType' => Domain_Database_Field_Factory::DATATYPE_INT,
				'expectedDataTypeAlias' => 'int'
			),
			array(
				'createFieldSql' => '`id` integer(11) unsigned NOT NULL',
				'expectedDataType' => Domain_Database_Field_Factory::DATATYPE_INT,
				'expectedDataTypeAlias' => 'integer'
			),
			array(
				'createFieldSql' => "`price_type` enum('fixed','percent') NOT NULL DEFAULT 'fixed'",
				'expectedDataType' 	=> Domain_Database_Field_Factory::DATATYPE_ENUM,
				'expectedDataTypeAlias' => 'enum'
			)
		);
	}
	
	/**
	 * Testcase to check if the dataType of a field gets determined as expected.
	 * 
	 * @param string $createFieldSql
	 * @param string $expectedDataType
	 * @param string $expectedDataTypeAlias
	 * @test
	 * @dataProvider extractDataTypeDataProvider
	 */
	public function extractDataType($createFieldSql, $expectedDataType, $expectedDataTypeAlias) {
		$field					= $this->factory->createFromSql($createFieldSql);
		
		$currentDataType		= $field->getDataType();
		$currentDataTypeAlias	= $field->getDataTypeAlias();
		
		$this->assertEquals($currentDataType, $expectedDataType, 'Factory determined unexpected data type');
		$this->assertEquals($currentDataTypeAlias, $expectedDataTypeAlias, 'Factory determined unexpected data type alias');
	}

	/**
	 * We expect that an  Exception_Parsing_ExtractFieldname exception will be thrown
	 * when an mal form field query gets passed.
	 * 
	 * @expectedException  Exception_Parsing_ExtractFieldname
	 * @test
	 * @return void
	 */
	public function missingFieldnameThrowsExtractFieldnameException() {
			//fieldname is missing: `id` int(11) unsigned NOT NULL'
		$mallFormedFieldQuery = 'int(11) unsigned NOT NULL';
		$field					= $this->factory->createFromSql($mallFormedFieldQuery);
	}

	/**
	 * When the datatype in the field query is missing an
	 * Exception_Pasing_ExtractDatatype should be thrown.
	 * 
	 * @expectedException Exception_Parsing_ExtractDatatype
	 * @test
	 * @return void
	 */
	public function missingDatatypeThrowsExtractDatatypeException() {
			//fieldname is missing: `id` int(11) unsigned NOT NULL'
		$mallFormedFieldQuery = '`id` unsigned NOT NULL';
		$field					= $this->factory->createFromSql($mallFormedFieldQuery);

	}
}