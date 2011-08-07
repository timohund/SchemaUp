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
 * Collection of database table information objects
 * 
 * @package SchemaUp
 * @subpackage Classes\System
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
class Domain_Database_TableCollection extends System_AbstractCollection implements Interface_SqlCreater{

	/**
	 * Method to add a table to the table collection.
	 * 
	 * @param Domain_Database_Table $table
	 */
	public function add(Domain_Database_Table $table) {
		parent::add($table);
	}
	
	public function getSql() {
		
	}
}