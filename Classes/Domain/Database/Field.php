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
 * @subpackage Classes\Domain
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
class Domain_Database_Field implements Interface_SqlParser {

	const DATATYPE_BIT			= 'bit';
	
	const DATATYPE_BOOL			= 'bool';
	
	const DATATYPE_TINYINT		= 'tinyint';
	const DATATYPE_SMALLINT 	= 'smallint';
	const DATATYPE_MEDIUMINT	= 'mediumint';
	const DATATYPE_INT			= 'int';
	const DATATYPE_BIGINT		= 'bigint';
	const DATATYPE_FLOAT		= 'float';
	const DATATYPE_DECIMAL		= 'decimal';

	const DATATYPE_TIMESTAMP	= 'timestamp';
	const DATATYPE_DOUBLE		= 'double';
	
	const DATATYPE_VARCHAR		= 'varchar';
	
	const DATATYPE_BLOB			= 'blob';
	const DATATYPE_MEDIUMBLOB	= 'mediumblob';
	
	protected $dataTypeAliases = array(
		self::DATATYPE_BIT 			=> array('bit'),
		self::DATATYPE_BOOL 		=> array('bool','boolean'),
		self::DATATYPE_TINYINT		=> array('tinyint'),
		self::DATATYPE_SMALLINT		=> array('smallint'),
		self::DATATYPE_MEDIUMINT 	=> array('mediumint'),
		self::DATATYPE_INT			=> array('int','integer'),
		self::DATATYPE_BIGINT		=> array('bigint'),
		self::DATATYPE_FLOAT		=> array('float'),
		self::DATATYPE_DECIMAL		=> array('decimal','dec','numeric','fixed'),
		self::DATATYPE_TIMESTAMP	=> array('timestamp'),
		self::DATATYPE_DOUBLE		=> array('double','real','double precision'),
		self::DATATYPE_VARCHAR		=> array('varchar'),
		self::DATATYPE_BLOB			=> array('blob'),
	);
	
	/**
	 * @var $sqlString string holds the sql string passed by setSql
	 */
	protected $sqlString 	= '';
	
	/**
	 * @var $fieldName string
	 */
	protected $fieldName	= '';

	/**
	 * @var $dataType = string
	 */
	protected $dataType = '';
	
	/**
	 * @var $dataTypeAlias string
	 */
	protected $dataTypeAlias = '';
	
	/**
	 * @var int
	 */
	protected $size = null;
	
	/**
	 * Method to set the name of the database field.
	 * 
	 * @param string $fieldName
	 */
	public function setFieldname($fieldName) {
		$this->fieldName = $fieldName;
	}
	
	/**
	 * Returns the fieldname of the database field.
	 * 
	 * @return string
	 */
	public function getFieldname() {
		return $this->fieldName;
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
	 * Method to set the sql string of the field.
	 * 
	 * @param string $sqlString
	 */
	public function setSql($sqlString) {
		$this->sqlString = $sqlString;
		$this->parseSql();
	}

	/**
	 * Method to parse the field sql.
	 * 
	 * @return bool
	 */
	public function parseSql() {
		$this->extractFieldname()->extractDatatype();
	}

	/**
	 * Extracts and sets the fieldname.
	 * 
	 * @return Domain_Database_Field
	 */
	protected function extractFieldname() {
		$matches = array();
		
			//`<fieldname>` ...
		if(preg_match('~^`(?<fieldname>[^`]*)`.*~is',$this->sqlString,$matches) == 1) {
			if(is_array($matches) && array_key_exists('fieldname',$matches)) {
				$fieldName = $matches['fieldname'];

				$this->setFieldname($fieldName);
			} else {
				throw new Exception_Parsing_ExtractFieldname('No fieldname found: '.var_export($matches,true));
			}
		} else {
			throw new Exception_Parsing_ExtractFieldname('Could not extract fieldname from field definition: '.$this->sqlString);
		}
		
		return $this;
	}
	
	/**
	 * Extracts and sets the datatype.
	 * 
	 * @return Domain_Database_Field
	 */
	protected function extractDatatype() {
		foreach ($this->dataTypeAliases as $dataType => $aliases) {
			foreach($aliases as $alias) {
				$matches = array();
				if(preg_match('~`[^`]*`.*'.$alias.'(\((?<size>[1-9][0-9]*)\))?.*~ims',$this->sqlString,$matches) == 1) {
					$this->setDatatype($dataType);
					$this->setDatatypeAlias($alias);
					
					if(is_array($matches) && array_key_exists('size',$matches)) {
						$size = intval($matches['size']);
						$this->setSize($size);
					}
					
					return $this;
				}
			}
		}
		
		throw new Exception_Parsin_ExtractDatatype('Unable to extract datatype from field definition: '.$this->sqlString);
	}
}
