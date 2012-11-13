<?php
namespace Primal\View;

class CompositeView extends \ArrayObject implements ViewInterface {

    public function add($view, $index = null) {
        if (!in_array($view, $this->getArrayCopy(), true)) {
            if ($index === null) $this[] = $view;
			else $this[$index] = $view;
        }
        return $this;
    }
    
    public function remove($view) {
		if (($i = array_search($view, $this->getArrayCopy(), true)) !== false) {
			unset($this[$i]);
		}
		
        return $this;
    }

    public function removeIndex($index) {
		if (isset($this[$index])) {
			unset($this[$index]);
		}
	
        return $this;
    }

	public function append($view, $index = null) {
		$this->add($view, $index);
		return $this;
	}
	
	public function prepend($view, $index = null) {
		$contents = $this->getArrayCopy();
		
		//if a specific index name is provided, we have to perform a merge
		//if no index needed, unshift is faster and resequences the numeric keys
		if ($index !== null) {
			$fill = array();
			$fill[$index] = $view;
			$contents = array_merge($fill, $contents);
		} else {		
			array_unshift($array, $view);	
		}
		
		$this->exchangeArray($contents);
		
		return $this;
	}
    
    public function render() {
		$output = $this->getArrayCopy();
        $output = array_map(function ($view) {
			return (string)$view;
		}, $output);
		
		return implode('', $output);
    }

	public function __toString() {
		return $this->render();
	}
	
}