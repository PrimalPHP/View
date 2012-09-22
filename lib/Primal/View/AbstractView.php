<?php 
namespace Primal\View;

abstract class AbstractView implements ViewInterface {
	
	abstract function render();
	
	public function __toString() {
		return $this->render();
	}
	
}

