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
 * Domain object that represents a database table.
 * 
 * @package SchemaUp
 * @subpackage Classes\System
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
class Domain_Database_Table_Table {
	
	const PREFIX_KEY = 'KEY';
	
	const PREFIX_PRIMARY_KEY = 'PRIMARY_KEY';
	
	
	/**
	 * @var string $name the name of the table
	 */
	protected $name;
		
	/**
	 * @var Domain_Database_FieldCollection
	 */
	protected $fields;
	
	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		$this->fields = new Domain_Database_Field_Collection();
	}
	
	/**
	 * Public method to set the name of the table.
	 * 
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
	}
	
	/**
	 * Public method to retrieve the name of the table.
	 * 
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * Returns the fields definitions from the table.
	 * 
	 * @return Domain_Database_Field_Collection
	 */
	public function getFields() {
		return $this->fields;
	}

	/**
	 * Method to check if a certain field exists in the this table.
	 * 
	 * @param Domain_Database_Field_Field $field
	 * @return boolean
	 */
	public function hasField(Domain_Database_Field_Field $field) {
		return $this->fields->hasField($field);
	}
	
	/**
	 * Adds a database field to the table.
	 * 
	 * @param Domain_Database_Field_Field $field
	 */
	public function addField(Domain_Database_Field_Field $field) {
		return $this->fields->add($field);
	}
	
	/**
	 * Retrieves a field with the same fieldname from the table.
	 * 
	 * @param Domain_Database_Field $field
	 * @return Domain_Database_Field
	 */
	public function getField(Domain_Database_Field_Field $field) {
		return $this->fields->getField($field);
	}	
}