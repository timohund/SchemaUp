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
abstract class Domain_Database_Visitor_AbstractMigratingSchemaVisitor extends Domain_Database_Visitor_AbstractSchemaVisitor {

	/**
	 * @var Domain_Database_Schema_MigrationStorage
	 */
	protected $migrationStorage;
	
	/**
	 * Method to pass a migration storage that collects
	 * the migration information.
	 *
	 * @param Domain_Database_Schema_MigrationStorage $migrationStorage
	 */
	public function setMigrationStorage(Domain_Database_Schema_MigrationStorage $migrationStorage) {
		$this->migrationStorage = $migrationStorage;
	}
}