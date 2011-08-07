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
 * Abstract base class for all testcases
 * 
 * @package SchemaUp
 * @subpackage Tests
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
abstract class AbstractSchemaUpTestcase extends PHPUnit_Framework_TestCase{ 

	/**
	 * Returns the content of a fixture file.
	 * 
	 * @param string $fixtureFileName
	 * @return string
	 */
	protected function getFixtureContent($fixtureFileName, $relativeToFile) {
		$path 		= realpath( dirname( $relativeToFile) ).'/fixtures/'.$fixtureFileName;
		$content 	= file_get_contents($path);
		
		return $content;
	}
}