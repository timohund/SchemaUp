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
 * Class to represent a database field.
 * 
 * @package SchemaUp
 * @subpackage Classes\Domain\Database\Field
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
class Domain_Database_Field_Field implements Interface_Visitable, Interface_Sqlable, Interface_Comparable{
	
	/**
	 * @var $name string
	 */
	protected $name	= '';

	/**
	 * @var $dataType = string
	 */
	protected $dataType = '';
	
	/**
	 * @var $dataTypeAlias string
	 */
	protected $dataTypeAlias = '';
	
	/**
	 * @var $size int
	 */
	protected $size = null;
	
	/**
	 * @var $autoIncrement boolean indicates if the field is an auto increment field or not
	 */
	protected $autoIncrement = false;

	/**
	 * @var int
	 */
	protected $precision = 0;

	/**
	 * @var
	 */
	protected $notNull = false;

	/**
	 * @var $sql string holds the sql used for the creation of this element
	 */
	protected $sql = '';
	
	/**
	 * @param string
 	 * @return Domain_Database_Field_Field
	 */
	public function setSql($sql) {
		$this->sql = $sql;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getSql() {
		return $this->sql;
	}
	
	/**
	 * Method to set the name of the database field.
	 * 
	 * @param string $fieldName
	 * @return Domain_Database_Field_Field
	 */
	public function setName($fieldName) {
		$this->name = $fieldName;
		return $this;
	}
	
	/**
	 * Returns the fieldname of the database field.
	 * 
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * Datatype of the field.
	 * 
	 * @param string $string
	 * @return Domain_Database_Field_Field
	 */
	public function setDatatype($dataType) {
		$this->dataType = $dataType;
		return $this;
	}
	
	/**
	 * Returns the datatype of the field.
	 * 
	 * @return string
	 */
	public function getDatatype() {
		return $this->dataType;
	}
	
	/**
	 * The used alias of the data type.
	 * 
	 * @param string $dataTypeAlias
	 * @return Domain_Database_Field_Field
	 */
	public function setDatatypeAlias($dataTypeAlias) {
		$this->dataTypeAlias = $dataTypeAlias;
		return $this;
	}
	
	/**
	 * Returns the alias of a data type.
	 * 
	 * @return string
	 */
	public function getDatatypeAlias() {
		return $this->dataTypeAlias;
	}
	
	/**
	 * Method to set the size of the database field.
	 * 
	 * @param int $size
	 * @return Domain_Database_Field_Field
	 */
	public function setSize($size) {
		$this->size = $size;
		return $this;
	}
	
	/**
	 * Returns the size of the database field.
	 * 
	 * @return int
	 */
	public function getSize() {
		return $this->size;
	}
	
	/**
	 * Returns if the field has a size definition (size is not null)
	 * 
	 * @return boolean
	 */
	public function hasSize() {
		return $this->getSize() !== null;
	}
	
	/**
	 * Method to set if the field is an auto increment field or not.
	 * 
	 * @param boolean $bool
	 * @return Domain_Database_Field_Field
	 */
	public function setAutoIncrement($bool = true) {
		$this->autoIncrement = $bool;
		return $this;
	}
	
	/**
	 * Method that retrieve of the field is an auto increment field or not.
	 * 
	 * @return boolean
	 */
	public function getAutoIncrement() {
		return $this->autoIncrement;
	}

	/**
	 * Method to pass the precision of the field.
	 * 
	 * @param $precision
	 * @return Domain_Database_Field_Field
	 */
	public function setPrecision($precision) {
		$this->precision = $precision;
		return $this;
	}

	/**
	 * Return the precision of the field.
	 * 
	 * @return int
	 */
	public function getPrecision() {
		return $this->precision;
	}

	/**
	 * Method to set the not null flag.
	 * 
	 * @param bool $notNull
	 * @return Domain_Database_Field_Field
	 */
	public function setNotNull($notNull = true) {
		$this->notNull = $notNull;
		return $this;
	}

	/**
	 * Returns the state of the notNull flag.
	 * 
	 * @return bool
	 */
	public function getNotNull() {
		return $this->notNull;
	}

	/**
	 * Implementation of the visitor interface
	 * 
	 * @param Interface_Visitor $visitor
	 */
	public function visit(Interface_Visitor $visitor) {
		$visitor->setVisitable($this);
	}

	/**
	 * The implementation of this method should
	 * return true if the object is equals and false if not.
	 *
	 * @param object $object
	 * @param boolean $recursive
	 * @return boolean
	 */
	public function equals($objectToCompare, $recursive = false) {
		System_ClassHandling_Tools::assertType('Domain_Database_Field_Field',$objectToCompare);
		$equals = false;
		/** @var $objectToCompare Domain_Database_Field_Field */
		$equals = ($this->getAutoIncrement() == $objectToCompare->getAutoIncrement());

		if($equals) { 	$equals = $equals && ($this->getDatatype() == $objectToCompare->getDatatype()); }
		if($equals) {  	$equals = $equals && ($this->getName() == $objectToCompare->getName()); }
		if($equals) { 	$equals = $equals && ($this->getPrecision() == $objectToCompare->getPrecision()); }
		if($equals) { 	$equals = $equals && ($this->getSize() == $objectToCompare->getSize()); }
		if($equals) {	$equals = $equals && ($this->getNotNull() == $objectToCompare->getNotNull()); }

		return $equals;
	}
}
