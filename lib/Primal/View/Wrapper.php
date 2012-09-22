<?php
namespace Primal\View;

/**
 * Wrapper allows you to wrap a view with two other views without altering the main contents.
 *
 * @package Primal View
 */

class Wrapper extends CompositeView {

	/**
	 * View content to output before the main contents
	 *
	 * @var string|ViewInterface
	 */
	public $prefix = null;
	
	/**
	 * View content to output after the main contents
	 *
	 * @var string|ViewInterface
	 */
	public $suffix = null;
	
	/**
	 * Replaces the prefix with the passed view
	 *
	 * @param string|ViewInterface $view 
	 * @return $this
	 */
	public function setPrefix($view) {
		$this->prefix = $view;
		return $this;
	}
	
	/**
	 * Replaces the suffix with the passed view
	 *
	 * @param string|ViewInterface $view 
	 * @return $this
	 */
	public function setSuffix($view) {
		$this->prefix = $view;
		return $this;
	}
	
	
	public function __construct($pre = null, $suf = null) {
		parent::__construct();
		
		if (!$this->prefix) $this->prefix = $pre ?: new CompositeView();
		if (!$this->suffix) $this->suffix = $suf ?: new CompositeView();
	}
	

	public function render() {
		
		$stack = array();
		
		if ($this->prefix !== null) {
			$stack[] = (string)$this->prefix;
		}

		if ($this->count()) {
			$stack[] = parent::render();
		}

		if ($this->suffix !== null) {
			$stack[] = (string)$this->suffix;
		}

		return implode('', $stack);
	}
	
}