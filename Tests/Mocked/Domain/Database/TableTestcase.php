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
class Mocked_Domain_Database_TableTestcase extends Mocked_AbstractMockedTestcase {
	
	/**
	 * @var $table Domain_Database_Table
	 */
	protected $table;
	
	/**
	 * @return void
	 */
	public function setUp() {
		$this->table = new Domain_Database_Table();
	}
	
	/**
	 * Dataprovider with a create table statement,
	 * and the expected number of fields that should
	 * be created, when the schema gets parsed.
	 * 
	 * @return array
	 */
	public function getFieldsDataProvider() {
		return array(
			array(
					//magento widget table
				'createTableSchema' => 
					"CREATE TABLE `widget` (
						  `widget_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
						  `code` varchar(255) NOT NULL,
						  `type` varchar(255) NOT NULL,
						  `parameters` text,
						  PRIMARY KEY (`widget_id`),
						  KEY `IDX_CODE` (`code`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Preconfigured Widgets' ",
				'expectedNumberOfFields' => 4
			),
			array(
				'createTableSchema' => "
					CREATE TABLE `coupon_aggregated` (
						  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
						  `period` date NOT NULL DEFAULT '0000-00-00',
						  `store_id` smallint(5) unsigned DEFAULT NULL,
						  `order_status` varchar(50) NOT NULL DEFAULT '',
						  `coupon_code` varchar(50) NOT NULL DEFAULT '',
 						 `coupon_uses` int(11) NOT NULL DEFAULT '0',
						  `subtotal_amount` decimal(12,4) NOT NULL DEFAULT '0.0000',
						  `discount_amount` decimal(12,4) NOT NULL DEFAULT '0.0000',
						  `total_amount` decimal(12,4) NOT NULL DEFAULT '0.0000',
						  `subtotal_amount_actual` decimal(12,4) NOT NULL DEFAULT '0.0000',
						  `discount_amount_actual` decimal(12,4) NOT NULL DEFAULT '0.0000',
						  `total_amount_actual` decimal(12,4) NOT NULL DEFAULT '0.0000',
						  PRIMARY KEY (`id`),
						  UNIQUE KEY `UNQ_COUPON_AGGREGATED_PSOC` (`period`,`store_id`,`order_status`,`coupon_code`),
						  KEY `IDX_STORE_ID` (`store_id`),
						  CONSTRAINT `FK_SALESTRULE_COUPON_AGGREGATED_STORE` FOREIGN KEY (`store_id`) REFERENCES `core_store` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE
					) ENGINE=InnoDB DEFAULT CHARSET=utf8				
				",
				"expectedNumberOfFields" => 12
			)
		);
	}
	
	/**
	 * 
	 * @dataProvider getFieldsDataProvider
	 * @test
	 */
	public function getFields($createTableSql, $expectedNumberOfFields) {
		$this->assertEquals($this->table->setSql($createTableSql)->getFields()->count(),$expectedNumberOfFields);
	}
}
