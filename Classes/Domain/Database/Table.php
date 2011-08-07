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
class Domain_Database_Table implements Interface_SqlParser{
	
	const PREFIX_KEY = 'KEY';
	
	const PREFIX_PRIMARY_KEY = 'PRIMARY_KEY';
	
	
	/**
	 * @var string $name the name of the table
	 */
	protected $name;
	
	/**
	 * @var string
	 */
	protected $sqlString;
	
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
		$this->fields = new Domain_Database_FieldCollection();
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
	 * @return Domain_Database_FieldCollection
	 */
	public function getFields() {
		return $this->fields;
	}
	
	/**
	 * Method to pass the sql string of this table.
	 * 
	 * @param string $sqlString
	 * @return Domain_Database_Table
	 */
	public function setSql($sqlString) {
		$this->sqlString = $sqlString;

		$this->parseSql();
		
		return $this;
	}
	
	/**
	 * Method to parse the create table statement.
	 * 
	 * @return boolean
	 */
	public function parseSql() {
		$matches 	= array();
			//starts with CREATE TABLE `tablename` ( fielddefinition) 
		$count 		= preg_match("~^[[:space:]]*CREATE[[:space:]]+TABLE[[:space:]]+`(?<tablename>[^`]*)`[[:space:]]+\((?<fielddefinitions>.*)\)~ims",$this->sqlString, $matches);
		
		if($count === 1 && is_array($matches) && array_key_exists('tablename',$matches) && array_key_exists('fielddefinitions',$matches)) {
			$this->table = trim($matches['tablename']);
			
			$fielddefinitions = trim($matches['fielddefinitions']);

			if($fielddefinitions != '') {
					//the single fields are seperated by , that should not have a ` prepended because this
					//is used for seperation in key definitions
				$lines = preg_split('~(?<fielddefinition>(?<!`))[[:space:]]*,~ims',$fielddefinitions) ;
				foreach($lines as $line) {
					$line = trim($line);
					//we have a field line when the line starts with `
					if(preg_match('~^`.*$~',$line) == 1) {
						$field = new Domain_Database_Field();
						$field->setSql(trim($line));
						$this->fields->add($field);
					}
				}
			}
			
		} else {
			throw new Exception_Parsing_CreateTable('Error during parsing of create table statement: '.$this->sqlString);
		}
	}
	
}