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
 * Factory class to create a field object from the sql field definition.
 * 
 * @package SchemaUp
 * @subpackage Classes\Domain\Database\Field
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
class Domain_Database_Field_Factory extends Domain_Database_AbstractSqlParsingFactory{
	const DATATYPE_BIT			= 'bit';
	
	const DATATYPE_BOOL			= 'bool';
	
	const DATATYPE_TINYINT		= 'tinyint';
	const DATATYPE_SMALLINT 	= 'smallint';
	const DATATYPE_MEDIUMINT	= 'mediumint';
	const DATATYPE_INT			= 'int';
	const DATATYPE_BIGINT		= 'bigint';
	const DATATYPE_FLOAT		= 'float';
	const DATATYPE_DECIMAL		= 'decimal';
	const DATATYPE_DOUBLE		= 'double';
	
	const DATATYPE_TIMESTAMP	= 'timestamp';
	const DATATYPE_DATE			= 'date';
	const DATATYPE_DATETIME		= 'datetime';

	const DATATYPE_CHAR			= 'char';
	const DATATYPE_VARCHAR		= 'varchar';
	
	const DATATYPE_TINYBLOB		= 'tinyblob';
	const DATATYPE_MEDIUMBLOB	= 'mediumblob';
	const DATATYPE_BLOB			= 'blob';
	const DATATYPE_LONGBLOB		= 'longblob';
	
	const DATATYPE_TINYTEXT		= 'tinytext';
	const DATATYPE_MEDIUMTEXT	= 'mediumtext';
	const DATATYPE_TEXT			= 'text';
	const DATATYPE_LONGTEXT		= 'longtext';
	
	const DATATYPE_ENUM			= 'enum';
	const DATATYPE_SET			= 'set';

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
		self::DATATYPE_DOUBLE		=> array('double','real','double precision'),
		self::DATATYPE_TIMESTAMP	=> array('timestamp'),
		self::DATATYPE_DATE			=> array('date'),
		self::DATATYPE_DATETIME		=> array('datetime'),
		self::DATATYPE_CHAR			=> array('char'),
		self::DATATYPE_VARCHAR		=> array('varchar'),
		self::DATATYPE_TINYBLOB		=> array('tinyblob'),
		self::DATATYPE_MEDIUMBLOB	=> array('mediumblob'),
		self::DATATYPE_BLOB			=> array('blob'),
		self::DATATYPE_LONGBLOB		=> array('longblob'),
		self::DATATYPE_TINYTEXT		=> array('tinytext'),
		self::DATATYPE_MEDIUMTEXT	=> array('mediumtext'),
		self::DATATYPE_TEXT			=> array('text'),
		self::DATATYPE_LONGTEXT		=> array('longtext'),
		self::DATATYPE_ENUM			=> array('enum'),
		self::DATATYPE_SET			=> array('set')
	);
		
	/**
	 * @var string
	 */
	protected $sqlString;
	
	/**
	 * Creates a field object from the sql field definition.
	 * 
	 * @param string $sqlString
	 * @return Domain_Database_Field_Field
	 */
	public function createFromSql($sqlString) {
		$this->sqlString = $sqlString;
		$field = $this->parseSql();
		
		return $field;
	}
	
	/**
	 * Method to parse the field sql.
	 * 
	 * @return Domain_Database_Field_Field
	 */
	protected function parseSql() {
		$field = new Domain_Database_Field_Field();
		$field->setSql($this->sqlString);
		
		$this->extractFieldname($field)->extractDatatype($field)->extractAutoIncrement($field);
		
		return $field;
	}

	/**
	 * Extracts and sets the fieldname.
	 * 
	 * @param Domain_Database_Field_Field $field
	 * @return Domain_Database_Field_Factory
	 */
	protected function extractFieldname(Domain_Database_Field_Field  $field) {
		$matches = array();
		
			//`<fieldname>` ...
		if(preg_match('~^[[:space:]]*`(?<fieldname>[^`]*)`.*~is',$this->sqlString,$matches) === 1) {
			if(is_array($matches) && array_key_exists('fieldname',$matches)) {
				$fieldName = $matches['fieldname'];

				$field->setName($fieldName);
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
	 * @param Domain_Database_Field_Field $field
	 * @return Domain_Database_Field_Factory
	 */
	protected function extractDatatype(Domain_Database_Field_Field $field) {
		foreach ($this->dataTypeAliases as $dataType => $aliases) {
			foreach($aliases as $alias) {
				$matches = array();
				
				// `FIELDNAME` DATATYPE(DATATYPE_INFORMATION) followed by at least one space or line end
				if(preg_match('~`[^`]*`.*'.$alias.'(\((?<datatype_information>[^\)]*)\))?([[:space:]]+.*|$)~ims',$this->sqlString,$matches) === 1) {
					$field->setDatatype($dataType);
					$field->setDatatypeAlias($alias);

					if(array_key_exists('datatype_information', $matches)) {
						$dataTypeInformation = $matches['datatype_information'];

						//here we parse the datatype information
						//it can be simply the size
						switch ($dataType){

							case self::DATATYPE_ENUM:
							case self::DATATYPE_SET:

							break;

							default:
								$datatypeInformationMatches = array();
								$pattern = '~(?<size>[1-9][0-9]*)(,(?<precision>[1-9][0-9]*))?~';
								if(preg_match($pattern,$dataTypeInformation,$datatypeInformationMatches) > 0) {

									//((?<size>[1-9][0-9]*)(,(?<precision>[1-9][0-9]*))?
									if(is_array($datatypeInformationMatches) && array_key_exists('size',$datatypeInformationMatches)) {
										$size = intval($datatypeInformationMatches['size']);
										$field->setSize($size);
									}

									if(is_array($datatypeInformationMatches) && array_key_exists('precision',$datatypeInformationMatches)) {
										$precision = intval($datatypeInformationMatches['precision']);
										$field->setPrecision($precision);
									}
								}

							break;
						}

					}

					return $this;
				}
			}
		}
		
		throw new Exception_Parsing_ExtractDatatype('Unable to extract datatype from field definition: '.$this->sqlString);
	}
	
	/**
	 * Extracts if the field is an AUTO INCREMENT field
	 * and set sets the auto increment flag if needed.
	 * 
	 * @param Domain_Database_Field_Field $field
	 * @return Domain_Database_Field_Factory
	 */
	protected function extractAutoIncrement(Domain_Database_Field_Field $field) {
		if(preg_match('~.*AUTO_INCREMENT.*~ims', $this->sqlString) === 1) {
			$field->setAutoIncrement(true);
		}
		
		return $this;
	}
}