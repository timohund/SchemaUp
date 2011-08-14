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
 * Interface for compareable objects.
 *
 * @package SchemaUp
 * @subpackage Classes\Interface
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
interface Interface_Comparable {

	/**
	 * The implementation of this method should
	 * return true if the object is equals and false if not.
	 *
	 * @param object $object
	 * @param boolean $recursive
	 * @return boolean
	 */
	public function equals($objectToCompare, $recursive = false);
}

 
