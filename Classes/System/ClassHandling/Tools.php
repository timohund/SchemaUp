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
 * Tools class with some usefull functions when dealing with classes.
 * 
 * @package SchemaUp
 * @subpackage System\ClassHandling\Tools
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
class System_ClassHandling_Tools {
	/**
	 * Function to check if an object is from an expected type.
	 *
	 * @param string $expectedType the classname of the expected type
	 * @param mixed $dataToCheck the object that should be checked
	 * @throws Exception_ClassHandling_UnexpectedType
	 * @return void
	 */
	public static function assertType($expectedType, $dataToCheck) {
		if(!$dataToCheck instanceof $expectedType) {
			if(is_object($dataToCheck)) {
				$actualType = get_class($dataToCheck);
			} else {
				$actualType = gettext($dataToCheck);
			}

			$message = "assertType determined unexpected data with  ".$actualType." expected ".$expectedType;
			throw new Exception_ClassHandling_UnexpectedType($message);
		}
	}
}