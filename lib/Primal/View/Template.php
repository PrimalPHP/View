<?php
namespace Primal\View;

/**
 * View - Basic class for rendering the contents of a view file with a set of predefined variables
 * The view class is referenced like so:
 * 		$v = new View('name');
 *		$v['variable'] = 'some value';
 *		$contents = $v->render();
 * Within the render() function, $v['variable'] becomes $variable to the view file.
 * @package Primal
 * @author Jarvis Badgley
 * @copyright 2008 - 2011 Jarvis Badgley
 */


class Template extends \ArrayObject implements ViewInterface {
	private $file;

	function __construct($file) {
		if (file_exists($file)) {
			$this->file = $file;
		} else {
			throw new \RuntimeException("The defined Template does not exist: $file");
		}
	}

	/**
	 * Imports a named array into the view variables
	 *
	 * @param array $in
	 */	
	public function import($in) {
		$this->exchangeArray( array_merge($this->export(), $in) );
	}

 
	/**
	 * Renders the view in the output buffer and returns the result as a string
	 *
	 * @return string
	 */	
	public function render() {
		extract($this->getArrayCopy());
		ob_start();
		include($this->file);
		return ob_get_clean();
	}
	
	
	public function __toString() {
		return $this->render();
	}

}
