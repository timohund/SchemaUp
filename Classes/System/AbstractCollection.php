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
 * Abstract Collection class.
 * 
 * @package SchemaUp
 * @subpackage Classes\System
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
class System_AbstractCollection extends ArrayObject { 

	/**
	 * Method to add an object to the collection.
	 * 
	 * @param object $object
	 */
	public function add($object) {
		$this->append($object);
	}

	
	/**
	 * Returns the number of items in the collection.
	 * 
	 * @return int
	 */
	public function getCount() {
		return $this->count();
	}
}