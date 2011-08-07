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
 * @subpackage Classes\System
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
class System_Autoloader {
	
	/**
	 * This method is used to register the autoloader itself
	 * as classloader.
	 * 
	 * @return void
	 */
	static function register() {
		$classLoader = new System_Autoloader();
		spl_autoload_register(array($classLoader, 'load'));
	}
	
	/**
	 * Loads the class the sticks to the naming convention.
	 * 
	 * @param string $className: Name of the class/interface to load
	 * @return void
	 */
	static public function load($className) {
		$classNameParts	= explode('_', $className);
		$pathSegment	= implode('/',$classNameParts);
		$classPath		= realpath( dirname(__FILE__)).'/../../Classes/'.$pathSegment.'.php';
		$testPath		= realpath( dirname(__FILE__)).'/../../Tests/'.$pathSegment.'.php';
		
		if (file_exists($classPath)) {
			require_once($classPath);
		} elseif (file_exists($testPath)) {
			require_once($testPath);
		} else {
			throw new Exception_ClassNotLoadable('The class '.$className.' is not loadable by convention!');
		}
	}
}
