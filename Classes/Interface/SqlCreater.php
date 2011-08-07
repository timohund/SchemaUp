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
 * Interface for all classes that can create
 * sql statements with toSql
 * 
 * @package SchemaUp
 * @subpackage Classes\Interface
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
interface Interface_SqlCreater{

	/**
	 * Must return an executable sql statement.
	 * 
	 * @return string
	 */
	public function getSql();
}