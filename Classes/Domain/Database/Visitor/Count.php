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
 * Interface for factorys that can create objects from sql
 * 
 * @package SchemaUp
 * @subpackage Classes\Domain\Database\Visitor
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
class Domain_Database_Visitor_Count extends Domain_Database_Visitor_AbstractSchemaVisitor{
	
	/**
	 * @var $schemaNodeCount int
	 */
	protected $schemaNodeCount;
	
	/**
	 * @var $tableNodeCount int
	 */
	protected $tableNodeCount;
	
	/**
	 * @var $fieldNodeCount int
	 */
	protected $fieldNodeCount;
	
	/**
	 * Working method of the visitor in this case a simple counting visitor.
	 * 
	 * @param Interface_Visitable $visited
	 */
	protected function doWork(Interface_Visitable $visited) {
		$class = get_class($visited);
		
		switch($class) {
			case 'Domain_Database_Schema_Schema':
				$this->schemaNodeCount++;
			break;
			
			case 'Domain_Database_Table_Table':
				$this->tableNodeCount++;
			break;
			
			case 'Domain_Database_Field_Field':
				$this->fieldNodeCount++;	
			break;	
		}
	}
	
	/**
	 * @return int
	 */
	public function getSchemaNodeCount() {
		return $this->schemaNodeCount;
	}
	
	/**
	 * @return int
	 */
	public function getTableNodeCount() {
		return $this->tableNodeCount;
	}
	
	/**
	 * @return int
	 */
	public function getFieldNodeCount() {
		return $this->fieldNodeCount;
	}
}
?>