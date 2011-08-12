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
 * Testcase to check if the FieldCollection works as expected.
 *
 * @package SchemaUp
 * @subpackage Tests\Mocked\Domain\Database
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
 class Mocked_Domain_Database_Field_CollectionTestcase extends Mocked_AbstractMockedTestcase{

	/**
	 * @var \Domain_Database_Field_Collection
	 */
	protected $fieldCollection;

	/**
	 * @return void
	 */
	public function setUp() {
		$this->fieldCollection = new Domain_Database_Field_Collection();
	}

	/**
	 * Simple testcase to check if the collection can return a field
	 * with the same field name.
	 *
	 * @test
	 * @return void
	 */
	public function getField() {
		$test = new Domain_Database_Field_Field();
		$test->setName('firstname');

		$test2 = new Domain_Database_Field_Field();
		$test2->setName('lastname');

		$this->fieldCollection->addField($test);
		$this->fieldCollection->addField($test2);

		$retrieved = $this->fieldCollection->getField($test);

		$this->assertSame($test, $retrieved,'The inserted and retieved fields in the collection are not the same.');
	}

	/**
	 * Testcase to check if hasField works as expected.
	 * 
	 * @test
	 * @return void
	 */
	public function hasField() {
		$test = new Domain_Database_Field_Field();
		$test->setName('firstname');

		$test2 = new Domain_Database_Field_Field();
		$test2->setName('lastname');

		$this->assertFalse($this->fieldCollection->hasField($test),'Has field determined the existence of a none existing field');

		$this->fieldCollection->addField($test);
		$this->fieldCollection->addField($test2);

		$this->assertTrue($this->fieldCollection->hasField($test),'Has field determined the existence of a none existing field');

	}
 }
