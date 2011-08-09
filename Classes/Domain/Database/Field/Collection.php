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
class Domain_Database_Field_Collection extends System_AbstractCollection implements Interface_Compareable{

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
	 * Determine if on collection contains the same fields as another collection.
	 * 
	 * @param Domain_Database_Field_Collection $toCompate
	 */
	public function equals($toCompare) {
		System_Tools::assertType('Domain_Database_Field_Collection', $toCompare);
		
		$equals = true;
		$equals = $equals && ($this->getCount() == $toCompare->getCount());
		
			//if the collection contain a diffrent amount of fields, we
			//do not need to compare them.
		if($equals) {
			for($it = $this->getIterator(); $it->valid(); $it->next()) {
					//@var $currentField Domain_Database_Table_Field
				$currentFieldSourceSchema = $it->current();
				$currentFieldTargetSchema = $toCompare->getField($currentFieldSourceSchema);
				
				if($currentFieldTargetSchema instanceof Domain_Database_Field_Field) {
					$equals == $equals && ($currentFieldSourceSchema->equals($currentFieldTargetSchema));
				} else {
					$equals = false;
				}
				
					//as soon as equals is false we can set equals to false and return
				if(!$equals) {
					$equals = false;
					break;
				}
			}
		}
				
		return $equals;
	}
}