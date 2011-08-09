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
class Domain_Database_Field_Field implements Interface_Visitable, Interface_Sqlable{
	
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
	 * @var $sql string holds the sql used for the creation of this element
	 */
	protected $sql;
	
	/**
	 * @param string
	 */
	public function setSql($sql) {
		$this->sql = $sql;
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
	 */
	public function setName($fieldName) {
		$this->name = $fieldName;
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
	 */
	public function setDatatype($dataType) {
		$this->dataType = $dataType;
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
	 */
	public function setDatatypeAlias($dataTypeAlias) {
		$this->dataTypeAlias = $dataTypeAlias;
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
	 */
	public function setSize($size) {
		$this->size = $size;
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
	 * Method to set if wether the field is an auto increment field or not.
	 * 
	 * @param boolean $bool
	 */
	public function setAutoIncrement($bool = true) {
		$this->autoIncrement = $bool;
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
	 * Implemenation of the visitor interface
	 * 
	 * @param Interface_Visitor $visitor
	 */
	public function visit(Interface_Visitor $visitor) {
		$visitor->setVisitable($this);
	}
}
