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
 * Normally a visitor of the schema visits nodes in an expected order
 *
 * Schema -> Table -> Field
 *
 * In some cases it is needed to get values from the current table when
 * a certain field gets visited. This exception gets throws for example
 * a field gets visited from an unknown table.
 *
 * @package SchemaUp
 * @subpackage Classes\Exception
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
class Exception_Visitor_LogicException extends Exception_AbstractException {}
