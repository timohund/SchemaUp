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
 * Factory class to create a table object.
 * 
 * @package SchemaUp
 * @subpackage Classes\Domain\Table
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
class Domain_Database_Table_Factory extends Domain_Database_AbstractSqlParsingFactory {
	
	/**
	 * @var string $sqlString
	 */
	protected $sqlString;
	
	/**
	 * @var Domain_Database_Field_Factory
	 */
	protected $fieldFactory;
	
	/**
	 * Constructor
	 * 
	 * @return Domain_Database_Table_Factory
	 */
	public function __construct() {
		$this->fieldFactory = new Domain_Database_Field_Factory();
	}
	
	/**
	 * Creates a table object from a create table string.
	 * 
	 * @param string $sqlString
	 * @return Domain_Database_Table_Table
	 */
	public function createFromSql($sqlString) {
		$this->sqlString = $sqlString;
		$table = $this->parseSql();
		return $table;
	}
	
	/**
	 * Method to parse the create table statement.
	 * 
	 * @return boolean
	 */
	protected function parseSql() {
		$table = new Domain_Database_Table_Table();
	//	$this->sqlString = preg_replace('~(\s\s+)~',' ',$this->sqlString);
		$table->setSql($this->sqlString);
		$this->extractTablenameAndFielddefinitions($table);
		
		return $table;
	}
	
	/**
	 * Extracts the tablename and the field definitions
	 * from the CREATE TABLE statement.
	 * 
	 * @param Domain_Database_Table_Table $table
	 * @return Domain_Database_Table_Factory 
	 */
	protected function extractTablenameAndFielddefinitions(Domain_Database_Table_Table $table) {
		$matches 	= array();

		//starts with CREATE TABLE `tablename` ( fielddefinition) 
		$count 		= preg_match("~^[[:space:]]*CREATE[[:space:]]+TABLE[[:space:]]+`(?<tablename>[^`]*)`[[:space:]]+\((?<fielddefinitions>.*)\)~ims",$this->sqlString, $matches);
		
		if($count === 1 && is_array($matches) && array_key_exists('tablename',$matches) && array_key_exists('fielddefinitions',$matches)) {
			$tablename = trim($matches['tablename']);
			$table->setName($tablename);
			
			$fielddefinitions = trim($matches['fielddefinitions']);

			if($fielddefinitions != '') {
				$lines = $this->splitFieldDefinitionsIntoMultipleLines($fielddefinitions);
				foreach($lines as $line) {
					$line = trim($line);
					//we have a field line when the line starts with `
					if(preg_match('~^`.*$~',$line) == 1) {
						$field = $this->fieldFactory->createFromSql($line);
						$table->addField($field);
					}
				}
			}
			
		} else {
			throw new Exception_Parsing_CreateTable('Error during parsing of create table statement: '.$this->sqlString);
		}		
		
		return $this;
	}

	/**
	 * Splits a field definitions string into multiple lines.
	 * This needs to be done in php because the split character "," can also occure
	 * in definitions of the datatype precisions, or an enum field.
	 * 
	 * @param $fielddefinitions
	 * @return array
	 */
	protected function splitFieldDefinitionsIntoMultipleLines($fielddefinitions) {
		$lines		= array();

		$inBracketCounter = 0;
		$chrArray 	= preg_split('//u',$fielddefinitions, -1, PREG_SPLIT_NO_EMPTY);
		$line 		= '';
		$count 		= count($chrArray);
		$i = 0;
		foreach($chrArray as $character) {
			$i++;
			if($character != ',' || $inBracketCounter > 0) {
				$line .= $character;
			}
			if(($character == ',' || $i == $count) && $inBracketCounter == 0) {
				$lines[] = trim($line);
				$line = '';
			}
			if($character == '(') { $inBracketCounter++; }
			if($character == ')') { $inBracketCounter--; }
		}

		return $lines;
	}
 }