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
class Mocked_Domain_Database_SchemaMigratorTestcase extends Mocked_AbstractMockedTestcase {
	
	/**
	 * @var Domain_Database_SchemaMigrator
	 */
	protected $migrator;
	
	/**
	 * @return void
	 */
	public function setUp() {
		$this->migrator = new Domain_Database_SchemaMigrator();
	}
	
	/**
	 * Dataprovided for database schema migrator testcase.
	 * 
	 * @return array
	 */
	public function addNoneExistingFieldDataprovider() {
		return array(
			//create a varchar field
			array(
				'schemaA' => "CREATE TABLE `document` (
								`id` int(32) NOT NULL
							) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci",
				'schemaB' => "CREATE TABLE `document` (
								`id` int(32) NOT NULL,
								`source` varchar(40) COLLATE utf8_unicode_ci NOT NULL
							) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci",
				'expectedUp' => 'ALTER TABLE `document` ADD `source` varchar(40) COLLATE utf8_unicode_ci NOT NULL;',
				'expectedDown' => 'ALTER TABLE `document` DROP `source`;'
			),
			//create a varchar field with some confusing whitespaces in schema
			array(
				'schemaA' => "CREATE TABLE `document` (
								`id` int(32) NOT NULL
							) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci",
				'schemaB' => "CREATE TABLE `document` (
								`id` int(32) NOT NULL,
								`source` 	varchar(40)    COLLATE utf8_unicode_ci NOT	 NULL
							) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci",
				'expectedUp' => 'ALTER TABLE `document` ADD `source` varchar(40) COLLATE utf8_unicode_ci NOT NULL;',
				'expectedDown' => 'ALTER TABLE `document` DROP `source`;'
			),
			//create a varchar field with some lower and uppercase diffrences
			array(
				'schemaA' => "create table `document` (
								`id` int(32) NoT NuLL
							) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci",
				'schemaB' => "CREATE TABLE `document` (
								`id` int(32) NOT NULL,
								`source` 	varchar(40)    CoLLATE utf8_unicode_ci NoT	 NuLL
							) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci",
				'expectedUp' => 'ALTER TABLE `document` ADD `source` varchar(40) COLLATE utf8_unicode_ci NOT NULL;',
				'expectedDown' => 'ALTER TABLE `document` DROP `source`;'
			),
			
			//create a mediumblob field
			array(
				'schemaA' => "CREATE TABLE `document` (
								`id` int(32) NOT NULL
							) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci",
				'schemaB' => "CREATE TABLE `document` (
							`id` int(32) NOT NULL,	
							`linktext` mediumblob NOT NULL
							) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci",
				'expectedUp' => 'ALTER TABLE `document` ADD `linktext` mediumblob NOT NULL;',
				'expectedDown' => 'ALTER TABLE `document` DROP `source`;'
			)
			
		);
	}
	
	/**
	 * This testcase is used to test if the migrator can
	 * create the correct statement when newfield is missing in schemaA
	 * 
	 * @test
	 * @dataProvider addNoneExistingFieldDataprovider
	 */
	public function canAddNoneExistsingField($schemaASql, $schemaBSql, $expectedUp, $expectedDown) {
	/*	$schemaA 	= new Domain_Database_Schema();
		$schemaA->setSql($schemaASql);
		
		$schemaB 	= new Domain_Database_Schema();
		$schemaB->setSql($schemaBSql);
		
		$upSql		= $this->migrator->setSourceSchema($schemaA)->setTargetSchema($schemaB)->getMigrationStatements()->getSql();
		$downSql	= $this->migrator->setSourceSchema($schemaB)->setTargetSchema($schemaA)->getMigrationStatements()->getSql();
		
		$this->assertEquals($expectedUp, $upSql, 'Migrator did not create expected schema up sql');
		$this->assertEquals($expectedDown, $downSql, 'Migrator did not create expected schema down sql'); */
	}
}