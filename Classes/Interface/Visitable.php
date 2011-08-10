<?php
interface Interface_Visitable {
	/**
	 * Each class that implements the visitor interface should 
	 * 
	 * @param Interface_Visitor $visitor
	 */
	public function visit(Interface_Visitor $visitor);
}