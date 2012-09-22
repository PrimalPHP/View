<?php 
namespace Primal\View;

/**
 * Much like Wrapper, Body allows for the creation of separate header and footer sections of the document, independent from the page content
 *
 * @package Primal View
 */

class Body extends HTMLTag {
	
	/**
	 * View content to output before the main contents
	 *
	 * @var string|ViewInterface
	 */
	public $header;
	
	/**
	 * View content to output before the main contents
	 *
	 * @var string|ViewInterface
	 */
	public $footer;
	
	

	public function __construct($header = null, $footer = null) {
		parent::__construct('body');
		
		if (!$this->header) $this->header = $header ?: new CompositeView();
		if (!$this->footer) $this->footer = $footer ?: new CompositeView();
	}
	
	/**
	 * Replaces the header with the passed view
	 *
	 * @param string|ViewInterface $view 
	 * @return $this
	 */
	public function setHeader($view) {
		$this->header = $view;
		return $this;
	}
	
	/**
	 * Replaces the footer with the passed view
	 *
	 * @param string|ViewInterface $view 
	 * @return $this
	 */
	public function setFooter($content) {
		$this->footer = $view;
		return $this;
	}
	
	public function render() {
		
		$stack = array();
		
		if ($this->prefix !== null) {
			$stack[] = (string)$this->prefix;
		}
		
		if ($this->header !== null) {
			$stack[] = (string)$this->header;
		}

		if ($this->count()) {
			$stack[] = parent::render();
		}

		if ($this->footer !== null) {
			$stack[] = (string)$this->footer;
		}
		
		if ($this->suffix !== null) {
			$stack[] = (string)$this->suffix;
		}
		

		return implode('', $stack);

	}
	
}
