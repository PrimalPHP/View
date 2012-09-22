<?php
namespace Primal\View;

interface ViewInterface {
	
	/**
	 * Render function which generates and returns the content of the view class
	 *
	 * @return string
	 */
	public function render();
	
	/**
	 * All view classes must implement a string conversion which returns the value of render.  Extending AbstractView accomplishes this for you.
	 *
	 * @return void
	 */
	public function __toString();
	
}

