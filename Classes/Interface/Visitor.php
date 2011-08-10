<?php
interface Interface_Visitor {
	/**
	 * The implementation should do something with the 
	 * visitable object
	 * 
	 * @param Interface_Visitable
	 */
	public function setVisitable(Interface_Visitable $visitable);
}