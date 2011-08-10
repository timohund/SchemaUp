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
 * Abstract base class for all schema visitors
 * 
 * @package SchemaUp
 * @subpackage Classes\Domain\Database\Visitor
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
abstract class Domain_Database_Visitor_AbstractSchemaVisitor implements Interface_Visitor {
	
	/**
	 * @var $currentSchema Domain_Database_Schema_Schema
	 */
	private $currentSchema;
	
	/**
	 * @var $currentTable Domain_Database_Table_Table
	 */
	private $currentTable;
	
	/**
	 * @var $currentField Domain_Database_Field_Field
	 */
	private $currentField;
	
	/**
	 * @return Domain_Database_Table_Table
	 */
	protected function getCurrentTable() {
		return $this->currentTable;
	}
	
	/**
	 * Working method of the visitor in this case a simple counting visitor.
	 * 
	 * @param Interface_Visitable $visited
	 */
	public function setVisitable(Interface_Visitable $visited) {
		$class = get_class($visited);
		
		switch($class) {
			case 'Domain_Database_Schema_Schema':
				$this->currentSchema = $visited;
			break;
			
			case 'Domain_Database_Table_Table':
				$this->currentTable = $visited;
			break;
			
			case 'Domain_Database_Field_Field':
				$this->currentField = $visited;
			break;
			
		}
		
		$this->doWork($visited);
	}
	
	/**
	 * The implementation should do something with the visited item.
	 * 
	 * @param Interface_Visitable $visitable
	 */
	abstract protected function doWork(Interface_Visitable $visitable);
}

?>