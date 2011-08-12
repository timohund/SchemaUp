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
 * Visits the source schema and checks for each node, if it
 * still exists in the target schema.
 *
 * @package SchemaUp
 * @subpackage Classes\Domain\Database\Visitor
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
class Domain_Database_Visitor_Removed extends Domain_Database_Visitor_AbstractMigratingSchemaVisitor {

	/**
	 * @var Domain_Database_Schema_Schema
	 */
	protected $targetSchema = null;

	/**
	 * @var array
	 */
	protected $removedTableNames = array();

	/**
	 * This method is used to set the target schema that should be used to check
	 * if the item still exists in the target schema.
	 *
	 * @param Domain_Database_Schema_Schema $targetSchema
	 * @return Domain_Database_Visitor_Removed
	 */
	public function setTargetSchema(Domain_Database_Schema_Schema $targetSchema) {
		$this->targetSchema = $targetSchema;
		return $this;
	}

	/**
	 * The implementation should do something with the visited item.
	 *
	 * @param Interface_Visitable $visitable
	 */
	protected function doWork(Interface_Visitable $visitable) {
		$class = get_class($visitable);

		switch($class) {
			case 'Domain_Database_Table_Table':
				/** @var $visitable  Domain_Database_Table_Table */
				if(!$this->targetSchema->hasTable($visitable)) {
					$this->removedTableNames[] = $visitable->getName();
					$this->migrationStorage->add('DROP TABLE `'.$visitable->getName().'`');
				}
			break;
			case 'Domain_Database_Field_Field':
				/** @var $visitable  Domain_Database_Field_Field */
				$fieldTable = $this->getCurrentTable();

				if(!array_search($fieldTable->getName(),$this->removedTableNames)) {
					if($this->targetSchema->hasTable($fieldTable)) {
						$targetSchemaTable = $this->targetSchema->getTable($fieldTable);
						if(!$targetSchemaTable->hasField($visitable)) {
							$this->migrationStorage->add('ALTER TABLE `'.$fieldTable->getName().'` DROP `'.$visitable->getName().'`');
						}
					}
				}
			break;
		}
	}
}