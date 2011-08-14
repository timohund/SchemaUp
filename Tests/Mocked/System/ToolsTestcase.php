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
 * Testcase for class handling tools class.
 *
 * @package SchemaUp
 * @subpackage \Tests\Mocked\System
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
class Mocked_System_ClassHandling_ToolsTestcase extends Mocked_AbstractMockedTestcase {

	/**
	 * Data provider for the assertType testcase.
	 * 
	 * @return array
	 */
	public function assertTypeDataProvider() {
		return array(
			array(
				'expectedType' => 'Domain_Database_Field_Field',
				'passedObject' => new Domain_Database_Field_Field(),
				'expectedResult' => true
			),
			array(
				'expectedType' => 'Domain_Database_Field_Field',
				'passedObject' => new Domain_Database_Table_Table(),
				'expectedResult' => false
			),
			array(
				'expectedType' => 'Domain_Database_Field_Field',
				'passedObject' => 'foobar',
				'expectedResult' => false
			),
		);
	}

	/**
	 * Testcase for the assertType function.
	 * 
	 * @param $expectedType
	 * @param $passedObject
	 * @param $expectedResult
	 * @dataProvider assertTypeDataProvider
	 * @return void
	 */
	public function test_assertType($expectedType, $passedObject, $expectedResult) {
		$isExpectedType = true;

		try {
			System_ClassHandling_Tools::assertType($expectedType,$passedObject);
		} catch (Exception_ClassHandling_UnexpectedType $e){
			$isExpectedType = false;
		}

		$this->assertEquals($expectedResult, $isExpectedType, 'Error during type verification in assertType');
	}
}
