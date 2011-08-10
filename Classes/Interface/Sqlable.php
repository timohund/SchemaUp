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
 * Interface for classes where sql can be passed and retrieved.
 * 
 * @package SchemaUp
 * @subpackage Classes\Interface
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
interface Interface_Sqlable{

	/**
	 * Must return an executable sql statement.
	 * 
	 * @return string
	 */
	public function getSql();
}