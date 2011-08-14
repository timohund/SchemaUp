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
 * Testclass for field objects.
 * 
 * @package SchemaUp
 * @subpackage Tests\Mocked\Domain\Database\Field
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
class Mocked_Domain_Database_Field_FieldTestcase extends Mocked_AbstractMockedTestcase {

	/**
	 * Testcase for the Equals method.
	 *
	 * @test
	 * @return void
	 */
	public function equals() {
		$emptyOn 	= new Domain_Database_Field_Field();
		$emptyTwo 	= new Domain_Database_Field_Field();

		$this->assertTrue($emptyOn->equals($emptyTwo));

		$diffrentOne = new Domain_Database_Field_Field();
		$diffrentOne->setAutoIncrement(true)->setDatatype(Domain_Database_Field_Factory::DATATYPE_BIGINT)->setPrecision(1);
		$diffrentTwo = new Domain_Database_Field_Field();
		$diffrentTwo->setAutoIncrement(true)->setDatatype(Domain_Database_Field_Factory::DATATYPE_BIGINT)->setPrecision(2);
		$this->assertFalse($diffrentOne->equals($diffrentTwo),'Expected diffrence between diffrentOne and diffrentTwo');
	}
}