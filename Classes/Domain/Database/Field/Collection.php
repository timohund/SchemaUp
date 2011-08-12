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
 * Object that represents a collection of database fields.
 * 
 * @package SchemaUp
 * @subpackage Classes\Domain
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
class Domain_Database_Field_Collection extends System_AbstractCollection implements Interface_Visitable{

	/**
	 * Method to add a new database field to the field collection.
	 * 
	 * @param Domain_Database_Field_Field $fieldToAdd
	 * @return Domain_Database_Field_Collection
	 */
	public function addField(Domain_Database_Field_Field $fieldToAdd) {
		$this->add($fieldToAdd);

		return $this;
	}

	/**
	 * This method is used to check if a field with
	 * the same name of the given field exists in the field collection.
	 * 
	 * @param Domain_Database_Field_Field $field
	 * @return boolean
	 */
	public function hasField(Domain_Database_Field_Field $fieldToSearch) {
		return $this->getField($fieldToSearch) !== false;
	}
	
	/**
	 * Method to retrieve a field from the field collection.
	 * 
	 * @param Domain_Database_Field_Field $fieldToSearch
	 * @return Domain_Database_Field_Field returns the field or false if the field is not in the collection
	 */
	public function getField(Domain_Database_Field_Field $fieldToSearch) {
		$result = false;
		
		for($it = $this->getIterator(); $it->valid(); $it->next()) {
			if($it->current()->getName() == $fieldToSearch->getName()) {
				$result = $it->current();
				break;
			}
		}
		
		return $result;
	}
	
	/**
	 * Implementation of the visitor interface.
	 * 
	 * @param Interface_Visitor $visitor
	 */
	public function visit(Interface_Visitor $visitor) {
		$visitor->setVisitable($this);
		for($it = $this->getIterator(); $it->valid(); $it->next()) {
			$currentField = $it->current();
			$currentField->visit($visitor);
		}
	}
}