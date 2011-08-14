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
 * Testcase for the visitor that determines changes in tables
 * and fields from the source to the target schema.
 *
 * @package SchemaUp
 * @subpackage Classes\Domain\Database\Visitor
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
class Domain_Database_Visitor_Changed extends Domain_Database_Visitor_AbstractMigratingSchemaVisitor {

	/**
	 * @var Domain_Database_Schema_Schema
	 */
	protected $sourceSchema;

	/**
	 *
	 * @param Domain_Database_Schema_Schema $sourceSchema
	 * @return Domain_Database_Visitor_Changed
	 */
	public function setSourceSchema(Domain_Database_Schema_Schema $sourceSchema) {
		$this->sourceSchema = $sourceSchema;
	}

	/**
	 * Add alter table statements for changed fields.
	 *
	 * @param Interface_Visitable $visitable
	 */
	protected function doWork(Interface_Visitable $visitable) {
		$class = get_class($visitable);

		switch($class) {
			case 'Domain_Database_Field_Field':
				/** @var $targetSchemaField Domain_Database_Field_Field */
				$targetSchemaField = $visitable;
				$targetSchemaTable = $this->getCurrentTable();

				if($this->sourceSchema->hasTable( $targetSchemaTable )) {
					$sourceSchemaTable = $this->sourceSchema->getTable($targetSchemaTable);
					if($sourceSchemaTable->hasField($targetSchemaField)) {
						$sourceSchemaField = $sourceSchemaTable->getField($targetSchemaField);

						if(!$sourceSchemaField->equals($targetSchemaField)) {
							//source schema and target schema have table with same field but diffrent structure
							$migrationStatement = 'ALTER TABLE `'.$targetSchemaTable->getName().'` MODIFY '.$targetSchemaField->getSql();
							$this->migrationStorage->add($migrationStatement);
						}
					}
				}
			break;
		}

	}
}